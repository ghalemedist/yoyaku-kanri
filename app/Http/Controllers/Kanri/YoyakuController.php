<?php

namespace App\Http\Controllers\Kanri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Yoyakubi;
use App\Models\Yoyakuuser;
use App\Models\Yoyakujikan;
use App\Models\WeekdayJikan;
use App\Models\Yoyakutype;

use App\Http\Requests\YoyakuuserRequest;

use Mail;
use App\Mail\YoyakuMail;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Str;

class YoyakuController extends Controller
{
    private $db;
    private $yoyakubi;
    
    private $yoyakuuser;
    private $yoyakujikan;
    private $weekdayJikan;
    private $yoyakutype;

    public function __construct(
        DatabaseManager $db, 
        Yoyakubi $yoyakubi,
        Yoyakuuser $yoyakuuser,
        Yoyakujikan $yoyakujikan,
        WeekdayJikan $weekdayJikan,
        Yoyakutype $yoyakutype
    )
    {
        $this->db = $db;
        $this->yoyakubi = $yoyakubi;
        $this->yoyakuuser = $yoyakuuser;
        $this->yoyakujikan = $yoyakujikan;
        $this->weekdayJikan = $weekdayJikan;
        $this->yoyakutype = $yoyakutype;
    }

    /**
     * Yoyaku user and time by date id
     * 
     * @param Yoyakubi int
     * @return view
     */
    public function index(Request $request, Yoyakubi $yoyakubi)
    {
        if(empty($yoyakubi) || $yoyakubi->is_active == '0'){
            return redirect()->route('kanri.yoyaku.dashboard');
        }
        $request->session()->forget('yoyakuuser');
        $yoyakutype_category = session('yoyakutype_category')?session('yoyakutype_category'):1;
        $yoyakuUsers = $this->yoyakuuser
            ->from('yoyakuusers as yu')
            ->join('yoyakujikans as yj', 'yu.yoyakujikan_id', '=', 'yj.id')
            ->join('yoyakubis as yb', 'yj.yoyakubi_id', '=', 'yb.id')
            ->where('yj.yoyakutype_category', $yoyakutype_category)
            ->where('yb.id', $yoyakubi->id)
            ->where('yu.is_cancel', '0')
            ->select('yu.*')
            ->with(['yoyakujikan', 'yoyakutype'])
            ->get();

        return view('kanri.yoyakuuser')->with(compact(['yoyakubi', 'yoyakuUsers', 'yoyakutype_category']));
    }

    /**
     * Change jikan to diable and enable
     * 
     * @param Yoyakujikan int, Status int
     * @return redirect
     */
    public function yoyakujikan_change(Request $request, Yoyakujikan $yoyakujikan, $is_active)
    {
        if(empty($yoyakujikan)){
            return redirect()->route('kanri.yoyaku.dashboard');
        }

        $this->yoyakujikan->where('id', $yoyakujikan->id)->update(array('is_active' => $is_active));
        if($is_active == '0')
            session()->flash('message', $yoyakujikan->start_time_only.' 予約不可に変更しました');
        else
            session()->flash('message', $yoyakujikan->start_time_only.' 予約可に変更しました');
        return redirect()->route('kanri.yoyakuuser',['yoyakubi' => $yoyakujikan->yoyakubi_id]);
    }

    /**
     * Disable or enable whole day yoyakutime
     * bulk change
     * @param Yoyakubi int, Int Status
     */
    public function yoyakubi_change(Request $request, Yoyakubi $yoyakubi, $is_active)
    {
        if(empty($yoyakubi)){
            return redirect()->route('kanri.yoyaku.dashboard');
        }
        $type = session('yoyakutype_category')?session('yoyakutype_category'):1;
        
        $this->yoyakujikan->where('yoyakubi_id', $yoyakubi->id)->where('type', $type)->update(array('is_active' => $is_active));
        if($is_active == '0')
            session()->flash('message', $yoyakubi->date.' 一括で予約不可に変更しました');
        else
            session()->flash('message', $yoyakubi->date.' 一括で予約可に変更しました');
        return redirect()->route('kanri.yoyakuuser',['yoyakubi' => $yoyakubi->id, 'type' => $type]);
    }

    /**
     * Yoyaku user details
     * @param Yoyakuuser int
     * @return view user-detail
     */
    public function detail(Yoyakuuser $yoyakuuser)
    {
        if(empty($yoyakuuser) || $yoyakuuser->is_cancel == 1){
            return redirect()->route('kanri.yoyaku.dashboard');
        }
        
        return view('kanri.user-detail')->with(compact(['yoyakuuser']));
    }

    /**
     * Yoyaku user detail edit form display
     * @param Yoyakuuser int
     * @return view user-edit
     */
    public function edit(Yoyakuuser $yoyakuuser)
    {
        if(empty($yoyakuuser) || $yoyakuuser->is_cancel == 1){
            return redirect()->route('kanri.yoyaku.dashboard');
        }
        $yoyakutype_category = session('yoyakutype_category')?session('yoyakutype_category'):'1';
        $yoyakutype = $this->yoyakutype
            ->where('yoyakutype_category', $yoyakutype_category)
            ->get();

        $type = $yoyakuuser->yoyakujikan->type;
        $today = Carbon::today();
        $lastDate = Carbon::today()->addDays(60);
        $yoyakubi = $this->yoyakubi
            ->where("is_display", 1)
            ->where("is_active", 1)
            ->where('date', '>', $today)
            ->where('date', '<=', $lastDate)
            ->orderBy('date')
            ->with(array('yoyakujikan' => function($query) use ($yoyakutype_category){
                $query->where('yoyakutype_category', '=', $yoyakutype_category);
            }))
            ->get()->toArray();
            
        $currentJikans = $this->yoyakujikan
            ->where('yoyakubi_id', $yoyakuuser->yoyakujikan->yoyakubi_id)
            ->where('type', '=', $type)
            ->get();
        return view('kanri.user-edit')->with(compact(['yoyakuuser', 'yoyakubi', 'currentJikans', 'yoyakutype']));
    }

    /**
     * Yoyaku user detail Update
     * @param Yoyakuuser int
     * @return redirect
     */
    public function update(YoyakuuserRequest $request, Yoyakuuser $yoyakuuser)
    {
        if(empty($yoyakuuser)){
            return redirect()->route('kanri.yoyaku.dashboard');
        }
        $this->db->beginTransaction();
            
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
                'line_userId',
                'yoyaku_status'
            ]);
            
            $res = $this->yoyakuuser
                ->where('id', $yoyakuuser->id)
                ->update($input);
            
            $this->db->commit();
            session()->flash('message', '変更されました。');
            return redirect()->route('kanri.yoyakuuser.detail',['yoyakuuser' => $yoyakuuser->id]);
    }

    /**
     * Yoyaku user Delete
     * @param Yoyakuuser int
     * @return view user-delete
     */
    public function delete(Yoyakuuser $yoyakuuser)
    {
        if(empty($yoyakuuser) || $yoyakuuser->is_cancel == 1){
            return redirect()->route('kanri.yoyaku.dashboard');
        }
        
        return view('kanri.user-delete')->with(compact(['yoyakuuser']));
    }

    /**
     * Yoyaku user Destroy
     * @param Yoyakuuser int
     */
    public function destroy(Yoyakuuser $yoyakuuser)
    {
        if(empty($yoyakuuser) || $yoyakuuser->is_cancel == 1){
            return redirect()->route('kanri.yoyaku.dashboard');
        }
        $type = $yoyakuuser->yoyakujikan->type;
        // $this->yoyakujikan->find($yoyakuuser->yoyakujikan_id)->update(array(
        //     'is_active' => '1'
        // ));
        $this->yoyakuuser->find($yoyakuuser->id)->update(array(
            'is_cancel' => '1'
        ));
        session()->flash('message', '削除されました');
        return redirect()->route('kanri.yoyakuuser',['yoyakubi' => $yoyakuuser->yoyakujikan->yoyakubi_id, 'type' => $type]);
    }

    /**
     * Yoyaku user For 2 months
     * @param 
     * @return view
     */
    public function sixty_days()
    {
        $today = Carbon::today();
        $lastDate = Carbon::today()->addDays(60);
        $yoyakubi = $this->yoyakubi
            ->where("is_display", 1)
            ->where("is_active", 1)
            ->where('date', '>=', $today)
            ->where('date', '<=', $lastDate)
            ->with(array('yoyakujikan' => function($query){
                $query->where('type', '=', 1);
            }))
            ->orderBy('date')
            ->get();

        $yoyakubiOther = $this->yoyakubi
            ->where("is_display", 1)
            ->where("is_active", 1)
            ->where('date', '>=', $today)
            ->where('date', '<=', $lastDate)
            ->with(array('yoyakujikan' => function($query){
                $query->where('type', '=', 2);
            }))
            ->orderBy('date')
            ->get();

        return view('kanri.sixty-days')->with(compact(['yoyakubi','lastDate', 'yoyakubiOther']));
    }

    /**
     * Yoyaku user add
     * @param Yoyakubi int
     * @return view user-add
     */
    public function add(Request $request, Yoyakubi $yoyakubi)
    {
        if(empty($yoyakubi) || $yoyakubi->is_active == '0'){
            return redirect()->route('kanri.yoyaku.dashboard');
        }
        $yoyakutype_category = session('yoyakutype_category')?session('yoyakutype_category'):'1';
        $yoyakutype = $this->yoyakutype
            ->where('yoyakutype_category', $yoyakutype_category)
            ->get();

        $today = Carbon::today();
        $lastDate = Carbon::today()->addDays(60);
        $yoyakubis = $this->yoyakubi
            ->where('id', $yoyakubi->id)
            ->with(array('yoyakujikan' => function($query) use ($yoyakutype_category){
                $query->where('type', '=', $yoyakutype_category);
            }))
            ->first();
       
        return view('kanri.user-add')->with(compact(['yoyakubis', 'yoyakutype', 'yoyakutype_category']));
    }

    /**
     * Yoyaku user confirm viewe
     * @param Yoyakujikan int
     * @return redirect
     */
    public function confirm(YoyakuuserRequest $request, Yoyakubi $yoyakubi)
    {
        if(empty($yoyakubi) || $yoyakubi->is_active != '1'){
            return redirect()->route('kanri.yoyaku.dashboard');
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
            'pet_year',
            'pet_gender',
            'pet_type',
            'pet_message',
            'pet_message2',
            'pet_message3',
            'pet_message4',
            'pet_message5',
            'line_userId',
        ]);
        
        $yoyakujikan = $this->yoyakujikan->find($input['yoyakujikan_id']);
        $request->session()->put('yoyakuuser', $input);
        $yoyakutype_title = $this->yoyakutype
            ->where('id', $input['yoyakutype_id'])
            ->first('title');

        return view('kanri.user-confirm')->with(compact(['yoyakubi', 'yoyakujikan', 'yoyakutype_title']));
    }

    /**
     * Yoyaku user detail Store
     * @param Yoyakujikan int
     * @return redirect
     */
    public function store(YoyakuuserRequest $request, Yoyakubi $yoyakubi)
    {
        if(empty($yoyakubi) || $yoyakubi->is_active != '1'){
            return redirect()->route('kanri.yoyaku.dashboard');
        }
        $this->db->beginTransaction();
            
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
        ]);
        $input['token_id'] = Str::random(32);
        $res = $this->yoyakuuser->create($input);
        $this->db->commit();
        if($request->filled('your_email')){
            //$this->yoyakuStoreMail($res->id);
        }
        session()->flash('message', '予約追加されました');
        $request->session()->forget('yoyakuuser');
        $type = $request->input('jikan_type');
        return redirect()->route('kanri.yoyakuuser',['yoyakubi' => $yoyakubi->id]);
    }

    public function yoyakuStoreMail($id, $subject = '診察予約完了')
    {
        $yoyakuuser = $this->yoyakuuser->find($id);
        $mailData = [
            'title' => $subject,
            'subject' => $subject,
            'body' => '',
            'data' => $yoyakuuser,
            'yoyaku_url' => config('services.yoyaku_url')
        ];
         
        Mail::to($yoyakuuser->your_email)->send(new YoyakuMail($mailData));
    }
}
