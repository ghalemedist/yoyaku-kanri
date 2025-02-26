<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Database\DatabaseManager;

use App\Models\Yoyakubi;
use App\Models\Yoyakujikan;
use App\Models\Yoyakuuser;
use App\Models\Yoyakutype;
use App\Models\WeekdayJikan;
use App\Models\SiteSetting;

use App\Services\LineBotService as LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use App\LIFF\FlexYoyaku;
use App\LIFF\FlexYoyakups;
use Mail;
use App\Mail\YoyakuMail;
use App\Mail\YoyakuMailAdmin;
use App\Mail\PhotoshootMail;
use App\Mail\PhotoshootMailAdmin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    private $db;

    private $yoyakubi;

    private $yoyakujikan;

    private $yoyakuuser;

    private $weekdayJikan;

    private $siteSetting;

    private $yoyakutype;

    public function __construct(
        DatabaseManager $db, 
        Yoyakubi $yoyakubi, 
        Yoyakujikan $yoyakujikan, 
        Yoyakuuser $yoyakuuser,
        WeekdayJikan $weekdayJikan,
        SiteSetting $siteSetting,
        Yoyakutype $yoyakutype
    )
    {
        $this->db = $db;
        $this->yoyakubi = $yoyakubi;
        $this->yoyakujikan = $yoyakujikan;
        $this->yoyakuuser = $yoyakuuser;
        $this->weekdayJikan = $weekdayJikan;
        $this->siteSetting = $siteSetting;
        $this->yoyakutype = $yoyakutype;
    }

    public function site_setting()
    {
        $data = $this->siteSetting->find(1,['liffId', 'liff_channel_id', 
        'yoyaku_date', 'yoyaku_title', 'yoyaku_content', 'yoyaku_content_email', 'yoyaku_content_line',
    'yoyaku_title_premium', 'yoyaku_content_premium', ]);

        $yoyakubi = $this->yoyakubi->where('date', $data['yoyaku_date'])->first();
        $data['yoyakubi'] = $this->yoyakubi
            ->where('date', $data['yoyaku_date'])
            ->with('yoyakujikan')
            ->first();
        // if(!empty($yoyakubi)) {
        //     $data['yoyakubi_id'] = $yoyakubi->id;
        // }

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], 200);
    }

    public function get_line_userInfo($id_token)
    {
        $headers = ['Content-Type' => 'application/x-www-form-urlencoded'];
        $params = [
            'id_token' => $id_token,
            'client_id' => config('services.line.message.liff_channel_id')
        ];
        $request = Http::asForm()->post('https://api.line.me/oauth2/v2.1/verify', $params, $headers);
        return json_decode($request);
    }

    public function yoyaku_timelist($yoyakutype_category = '1')
    {
        $today = Carbon::today();
        $lastDate = Carbon::today()->addDays(60);
        // $data['yoyaku_time_list'] = $this->yoyakubi
        //     ->where("is_display", 1)
        //     ->where('date', '>', $today)
        //     ->where('date', '<=', $lastDate)
        //     ->orderBy('date')
        //     ->with('yoyakujikan')
        //     ->get();

        $data['yoyakutype'] = $this->yoyakutype
            ->where('yoyakutype_category', '=', $yoyakutype_category)
            ->get();
            
        // $count = $data['yoyaku_time_list']->count('id');



        $lastDate = Carbon::today()->addDays(28);
        $data['yoyaku_time_list'] = $this->yoyakubi
            ->select('yoyakubis.*')
            ->where("is_display", 1)
            ->where('date', '>', $today)
            ->where('date', '<=', $lastDate)
            ->orderBy('date')
            ->with(array('yoyakujikan' => function($query) use ($yoyakutype_category){
                $query->where('yoyakutype_category', '=', $yoyakutype_category);
            }))
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);

        
        // if($count < 60){
        //     $is_store = $this->store_yoyakubi($count);
        //     if($is_store)
        //         return redirect()->route('api.yoyaku_timelist', ['yoyakutype_category' => $yoyakutype_category]);
        // }else{
        //     $lastDate = Carbon::today()->addDays(28);
        //     $data['yoyaku_time_list'] = $this->yoyakubi
        //         ->select('yoyakubis.*')
        //         ->where("is_display", 1)
        //         ->where('date', '>', $today)
        //         ->where('date', '<=', $lastDate)
        //         ->orderBy('date')
        //         ->with(array('yoyakujikan' => function($query) use ($yoyakutype_category){
        //             $query->where('yoyakutype_category', '=', $yoyakutype_category);
        //         }))
        //         ->get();
        //     return response()->json([
        //         'status' => 'success',
        //         'data' => $data
        //     ], 200);
        // }   
    }

    public function store_yoyakubi($count) {
        $yoyakubis = [];
        $today = Carbon::today();
        for($i = $count; $i <= 60; $i++){
            $yoyakubis[] = getYoyakubiData($i);
        }
        $yoyakujikans = [];
        if($this->yoyakubi->upsert($yoyakubis, ['date'],['title','description'])){
            for($i = $count; $i <= 60; $i++){
                $date = getAddDays($i);
                $weekday_index = getWeekIndexByDate($date);
                $yoyakubi_id = $this->yoyakubi->where('date', $date)->first()->id;
                $weekdayJikan = $this->weekdayJikan->where('weekday_index', $weekday_index)
                    ->where('yoyakutype_category', '1')->get();
                if($weekdayJikan->count()){
                    foreach($weekdayJikan as $value){
                        $data = array(
                            'yoyakubi_id' => $yoyakubi_id,
                            'start_time' => $value->start_time,
                            'end_time' => $value->end_time,
                            'yoyakutype_category' => '1'
                        );
                        $res = $this->yoyakujikan->where($data)->first();
                        if(empty($res)){
                            $yoyakujikans[] = $data;
                        }
                    }
                }
                // $weekdayJikan2 = $this->weekdayJikan
                //     ->where('weekday_index', $weekday_index)
                //     ->where('yoyakutype_category', '2')->get();
                // if($weekdayJikan2->count()){
                //     foreach($weekdayJikan2 as $value){
                //         $data2 = array(
                //             'yoyakubi_id' => $yoyakubi_id,
                //             'start_time' => $value->start_time,
                //             'end_time' => $value->end_time,
                //             'yoyakutype_category' => '2'
                //         );
                //         $res2 = $this->yoyakujikan->where($data2)->first();
                //         if(empty($res2)){
                //             $yoyakujikans[] = $data2;
                //         }
                //     }
                // }
            }
        }
        if(!empty($yoyakujikans)){
            $this->yoyakujikan->upsert($yoyakujikans, ['yoyakubi_id', 'start_time', 'end_time', 'yoyakutype_category'],['start_time','end_time']);
        }
        return true;
    }

    public function timeinfo_byid($yoyakujikan)
    {
        $data = $this->yoyakujikan
            ->where("id", $yoyakujikan)
            // ->where("is_active", '1')
            ->with(['yoyakubi'])->first();
        if(!empty($data)){
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'some error',
                'data' => $data
            ], 200);
        }
            
    }

    public function appointment_store(Request $request)
    {
        try {
            $this->db->beginTransaction();
            $validator = Validator::make($request->all(), [
                'yoyakujikan_id' => ['required','integer', function($attribute, $value, $fail)use($request){
                    $checkStatus = $this->yoyakujikan->find($value);
                    if(empty($checkStatus) || $checkStatus->is_active != '1'){
                        $fail($attribute.' this time is not available');
                    }
                }],
                'yoyakutype_id' => 'required',
                'your_name' => 'required',
                'your_kana' => 'required',
                'postal_code' => 'required',
                'address_line' => 'required',
                'tel' => 'required',
                'pet_name' => 'required',
            ]);
            if( $validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'エーラが発生されました。もう一度入力ください。',
                    'data' =>  $validator->errors(),
                ]);
            }
            $input = $request->only([
                'yoyakujikan_id',
                'yoyakutype_id',
                'your_name',
                'your_kana',
                'your_email',
                'postal_code',
                'address_line',
                'tel',
                'pet_name',
                'pet_type',
                'pet_year',
                'pet_gender',
                'pet_message',
                'pet_message2',
                'pet_message3',
                'pet_message4',
                'pet_message5',
                // 'line_userId',
                // 'line_IDToken'
            ]);
            $input['token_id'] = Str::random(32);
            
            $res = $this->yoyakuuser->create($input);
            $yoyakujikan = $this->yoyakujikan->find($res->yoyakujikan_id);
            
            $this->db->commit();

            $newYoyakuUser = $this->yoyakuuser->find($res->id);
            //notify by email
            
            //notify by line
            if($request->filled('line_IDToken')){
                
                $lineUser = $this->get_line_userInfo($request->input('line_IDToken'));
                if(isset($lineUser->sub)){
                    $httpClient = new CurlHTTPClient(config('services.line.message.channel_token'));
                    $bot = new LINEBot($httpClient, ['channelSecret' => config('services.line.message.channel_secret')]);

                    $line_userId = $lineUser->sub;

                    $felxClass = new FlexYoyaku();
                    if($newYoyakuUser->yoyakujikan->type == '1') {
                        $messageTitle = '診察予約 完了';
                    }else {
                        $messageTitle = 'トリミング＆シャンプー予約完了';
                    }
                    $flexMessageBuilder = $felxClass->get($newYoyakuUser, $messageTitle);
                    $response = $bot->pushMessage($line_userId, $flexMessageBuilder);

                }
                
            }else{
                if($newYoyakuUser->yoyakujikan->type == '1'){
                    $this->yoyakuStoreMail($res->id, '診察ご予約ありがとうございます', 'store');
                }else{
                    $this->yoyakuStoreMail($res->id, 'トリミング＆シャンプーご予約ありがとうございます', 'store');
                }
            }
            if($newYoyakuUser->yoyakujikan->type == '1'){
                $this->yoyakuStoreMailAdmin($res->id, '診察ご予約が入りました', 'store');
            }else{
                $this->yoyakuStoreMailAdmin($res->id, 'トリミング＆シャンプーご予約が入りました', 'store');
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Appointment Created Successfully!',
                // 'data'    => $res
            ], 200);

        } catch (\Exception $e){
            $this->db->rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
        
    }

    public function yoyakuStoreMail($id, $subject, $action = 'store')
    {
        $yoyakuuser = $this->yoyakuuser->find($id);
        $mailData = [
            'title' => $subject,
            'subject' => $subject,
            'body' => '',
            'data' => $yoyakuuser,
            'action' => $action,
            'yoyaku_url' => config('services.yoyaku_url')
        ];
         
        Mail::to($yoyakuuser->your_email)->send(new YoyakuMail($mailData));
    }

    public function yoyakuStoreMailAdmin($id, $subject, $action = 'store')
    {
        $yoyakuuser = $this->yoyakuuser->find($id);
        $mailData = [
            'title' => $subject,
            'subject' => $subject,
            'body' => '',
            'data' => $yoyakuuser,
            'action' => $action
        ];
         
        // Mail::to('ghale@medist.com')->send(new YoyakuMailAdmin($mailData));
    }

    

    public function appointment_bytokenid($token_id)
    {
        $data['yoyakuuser'] = $this->yoyakuuser
            ->where("token_id", $token_id)
            ->where("is_cancel", '0')
            ->with(['yoyakujikan'])->first();

        $data['yoyakutype'] = $this->yoyakutype
            ->where('yoyakutype_category', '=', $data['yoyakuuser']->yoyakutype->yoyakutype_category)
            ->get();

        if(!empty($data)){
            return response()->json([
                'status' => 'success',
                'message' => '',
                'data' => $data
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => '予約が見つかりません。電話でご連絡ください。',
                'data' => $data
            ], 200);
        }
            
    }

    public function appointment_update(Request $request)
    {
        try {
            $this->db->beginTransaction();
            $validator = Validator::make($request->all(), [
                'yoyakujikan_id' => ['required','integer', function($attribute, $value, $fail)
                    use($request){
                        $token_id = $request->input('token_id');
                        $res = $this->yoyakuuser->where('token_id', $token_id)->first();
                        $prev = 0;
                        if(empty($res)){
                            $fail('その日時に予約できません。');
                        }else{
                            $prev = $res->yoyakujikan_id;
                        }
                        if($value != $prev){
                            $checkStatus = $this->yoyakujikan->find($value);
                            if(empty($checkStatus) || $checkStatus->is_active != '1'){
                                $fail($attribute.' this time is not available');
                            }
                        }
                }],
                'yoyakutype_id' => 'required',
                'your_name' => 'required',
                'your_kana' => 'required',
                'postal_code' => 'required',
                'address_line' => 'required',
                'tel' => 'required',
                'pet_name' => 'required',
                'token_id' => ['required','string', function($attribute, $value, $fail)
                    use($request){
                        $checkStatus = $this->yoyakuuser->where('token_id',$value)->first();
                        if(empty($checkStatus) || $checkStatus->is_cancel != '0'){
                            $fail('予約データを見つけません');
                        }
                }],
            ]);
            if( $validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => '予約が変更できません。電話かメールでご連絡ください。',
                    'data' =>  $validator->errors(),
                ]);
            }
            
            $input = $request->only([
                'yoyakujikan_id',
                'yoyakutype_id',
                'your_name',
                'your_kana',
                'your_email',
                'postal_code',
                'address_line',
                'tel',
                'pet_name',
                'pet_type',
                'pet_year',
                'pet_gender',
                'pet_message',
                'pet_message2',
                'pet_message3',
                'pet_message4',
                'pet_message5',
                'token_id'
            ]);
            $old = $this->yoyakuuser->where('token_id', $input['token_id'])->first();
            // $this->yoyakujikan->find($old->yoyakujikan_id)->update(array(
            //     'is_active' => '1'
            // ));
            
            $res = $this->yoyakuuser
                ->where('token_id', $input['token_id'])
                ->update($input);
            $this->db->commit();

            
            //notify by line
            if($request->filled('line_IDToken')){

                $lineUser = $this->get_line_userInfo($request->input('line_IDToken'));
                if(isset($lineUser->sub)){
                    $httpClient = new CurlHTTPClient(config('services.line.message.channel_token'));
                    $bot = new LINEBot($httpClient, ['channelSecret' => config('services.line.message.channel_secret')]);

                    $line_userId = $lineUser->sub;

                    $felxClass = new FlexYoyaku();
                    $newYoyakuUser = $this->yoyakuuser->find($old->id);
                    if($newYoyakuUser->yoyakujikan->type == '1') {
                        $messageTitle = '診察予約 更新完了';
                    }else {
                        $messageTitle = 'トリミング＆シャンプー 更新完了';
                    }
                    $flexMessageBuilder = $felxClass->get($newYoyakuUser, $messageTitle);
                    $response = $bot->pushMessage($line_userId, $flexMessageBuilder);
                }
                
            }else{
                if($request->filled('your_email')){
                    $this->yoyakuStoreMail($old->id, 'ご予約変更いたしました', 'update');
                }
            }

            $this->yoyakuStoreMailAdmin($old->id, '予約を変更しました', 'update');
            
            return response()->json([
                'status' => 'success',
                'message' => 'Appointment Updated Successfully!',
            ], 200);

        } catch (\Exception $e){
            $this->db->rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function appointment_cancel($token_id)
    {
        $dt = Carbon::now();
        // echo $dt->todateString();
        $response = array(
            'status' => 'error',
            'message' => ''
        );
        $res = $this->yoyakuuser->where('token_id', $token_id)->first();
        if($res){
            $d1 = Carbon::parse($res->yoyakujikan->yoyakubi->date);
            $now = Carbon::now();
            $now = $now->toDateString();
            $now = Carbon::parse($now);
            $diff = $d1->diffInDays($now);
            if($res->is_cancel > "0"){
                $response['message'] = 'エーラ、予約はもうキャンセルされています。';
            }else if($now->gt($d1)){
                $response['message'] = 'エーラ、予約のキャンセルができません。';
            }else{
                $this->yoyakuuser->find($res->id)->update(['is_cancel' => '1']);
                $response['status'] = 'success';
                $response['message'] = '予約はキャンセルされました。';
            }
        }else{
            $response['status'] = 'error';
            $response['message'] = 'エーラ、予約が見つかりません。';
        }
        return response()->json($response, 200);
    }

    /**
     * Get yoyakubi info by id
     * @param Yoyakubi $yoyakubi
     * @return response
     */
    public function yoyakubi_byid(Yoyakubi $yoyakubi)
    {
        $data = $this->yoyakubi
            ->where("id", $yoyakubi->id)
            ->with('yoyakujikan')
            ->first();
        if(!empty($data)){
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'some error',
            ], 200);
        }
    }

    /**
     * Store appointment for Photoshoot context on 2024-07-28
     * @param Request
     */
    public function appointment_store_ps(Request $request)
    {
        try {
            $this->db->beginTransaction();
            $validator = Validator::make($request->all(), [
                // 'yoyakujikan_id' => ['required'],
                'yoyakujikan_id' => ['required','integer', function($attribute, $value, $fail)use($request){
                    $timeslot = $this->yoyakujikan
                        ->where('id', $value)
                        ->where('is_active', 1)
                        ->whereDoesntHave('yoyakuActive')
                        ->exists();

                    if(!$timeslot){
                        $fail($attribute.' this time is not available');
                    }
                }],
                'your_name' => 'required',
                'your_kana' => 'required',
                'tel' => 'required',
                'pet_name' => 'required',
            ]);
            if( $validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'この時間帯は満員です。最初からやり直してください。',
                    'data' =>  $validator->errors(),
                ]);
            }
            $input = $request->only([
                'yoyakujikan_id',
                'yoyakutype_id',
                'your_name',
                'your_kana',
                'your_email',
                'tel',
                'pet_name',
                'pet_message',
                'pet_message2',
            ]);
         
            $input['token_id'] = Str::random(32);
            
            $res = $this->yoyakuuser->create($input);
            $yoyakujikan = $this->yoyakujikan->find($res->yoyakujikan_id);
            
            $this->db->commit();

            $newYoyakuUser = $this->yoyakuuser->find($res->id);
            //notify by email
            
            //notify by line
            if($request->filled('line_IDToken')){
                
                $lineUser = $this->get_line_userInfo($request->input('line_IDToken'));
                if(isset($lineUser->sub)){
                    $httpClient = new CurlHTTPClient(config('services.line.message.channel_token'));
                    $bot = new LINEBot($httpClient, ['channelSecret' => config('services.line.message.channel_secret')]);

                    $line_userId = $lineUser->sub;

                    $felxClass = new FlexYoyakups();
                    if($newYoyakuUser->yoyakujikan->type == '1') {
                        $messageTitle = '予約 完了';
                    }
                    
                    $flexMessageBuilder = $felxClass->get($newYoyakuUser, $messageTitle);
                    $response = $bot->pushMessage($line_userId, $flexMessageBuilder);

                }
                
            }else{
                if($newYoyakuUser->yoyakujikan->type == '1'){
                    $this->yoyakuStoreMailps($res->id, 'ご予約ありがとうございます', 'store');
                }
            }

            $this->yoyakuStoreMailAdminps($res->id, '予約が入りました', 'store');
            
            return response()->json([
                'status' => 'success',
                'message' => 'Appointment Created Successfully!',
            ], 200);

        } catch (\Exception $e){
            $this->db->rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
        
    }

    public function yoyakuStoreMailps($id, $subject, $action = 'store')
    {
        $event = $this->siteSetting->find(1,[ 'yoyaku_content_email', 'yoyaku_title' ]);
        $yoyakuuser = $this->yoyakuuser->find($id);
        $mailData = [
            'title' => $subject,
            'subject' => $subject,
            'body' => '',
            'data' => $yoyakuuser,
            'data_event' => $event,
            'action' => $action,
            'yoyaku_url' => config('services.yoyaku_url')
        ];
         
        Mail::to($yoyakuuser->your_email)->send(new PhotoshootMail($mailData));
    }

    public function yoyakuStoreMailAdminps($id, $subject, $action = 'store')
    {
        $yoyakuuser = $this->yoyakuuser->find($id);
        $mailData = [
            'title' => $subject,
            'subject' => $subject,
            'body' => '',
            'data' => $yoyakuuser,
            'action' => $action
        ];
         
        // Mail::to('media@happyplace.pet')->send(new PhotoshootMailAdmin($mailData));
        Mail::to('ghale@medist.jp')->send(new PhotoshootMailAdmin($mailData));
    }

    /**
     * update yoyaku setting form admin
     * @param Request
     */
    public function yoyaku_setting_update(Request $request)
    {
        try {
            $this->db->beginTransaction();
            $validator = Validator::make($request->all(), [
                'yoyaku_title' => ['required'],
            ]);
            if( $validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'エーラが発生されました。もう一度入力ください。',
                    'data' =>  $validator->errors(),
                ]);
            }
            $input = $request->only([
                'yoyaku_date',
                'yoyaku_title',
                'yoyaku_content',
                'yoyaku_content_email',
                'yoyaku_content_line',
                'yoyaku_title_premium',
                'yoyaku_content_premium',
            ]);
         
            $res = $this->siteSetting->where('id', '1')->update($input);
            
            $this->db->commit();

            return response()->json([
                'status' => 'success',
                'message' => '保存しました',
            ], 200);

        } catch (\Exception $e){
            $this->db->rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
        
    }

    /**
     * Get yoyakubi info by date
     * @param Request $request
     * @return response
     */
    public function yoyakubi_bydate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'yoyaku_date' => ['required'],
        ]);
        if( $validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'エーラが発生されました。もう一度入力ください。',
                'data' =>  $validator->errors(),
            ]);
        }
        $data = $this->yoyakubi
            ->where("date", $request->yoyaku_date)
            ->with('yoyakujikan')
            ->first();
        if(!empty($data)){
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'some error',
            ], 200);
        }
    }

    /**
     * Update yoyakubi timeslot
     * @param Request $request
     * @return response
     */
    public function yoyakubi_tsupdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_time' => ['required'],
            'id' => ['required'],
        ]);
        if( $validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'エーラが発生されました。もう一度入力ください。',
                'data' =>  $validator->errors(),
            ]);
        }
        $this->yoyakujikan->where('id', $request->id)->update(array(
            'start_time' => Carbon::parse($request->start_time)
        ));
        
        return response()->json([
            'status' => 'success',
            'message' => '編集しました'
        ], 200);
        
    }

    /**
     * Delete yoyakubi timeslot
     * @param Request $request
     * @return response
     */
    public function yoyakubi_tsdelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required'],
        ]);
        if( $validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'エーラが発生されました。もう一度入力ください。',
                'data' =>  $validator->errors(),
            ]);
        }
        $this->yoyakujikan->where('id', $request->id)->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => '削除しました'
        ], 200);
        
    }

     /**
     * Delete yoyakubi timeslot
     * @param Request $request
     * @return response
     */
    public function yoyakubi_tscreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'yoyakubi_id' => ['required'],
            'start_time' => ['required'],
        ]);

       
        if( $validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'エーラが発生されました。もう一度入力ください。',
                'data' =>  $validator->errors(),
            ]);
        }
        $input = $request->only([
            'yoyakubi_id',
            'is_premium'
        ]);
        $input['start_time'] = Carbon::parse($request->start_time);
        $input['end_time'] = Carbon::parse('18:00');

        $this->yoyakujikan->create($input);
        
        return response()->json([
            'status' => 'success',
            'message' => '追加しました'
        ], 200);
        
    }

   

}
