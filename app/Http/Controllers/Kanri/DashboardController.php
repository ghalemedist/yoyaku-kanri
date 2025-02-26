<?php

namespace App\Http\Controllers\Kanri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Yoyakubi;
use App\Models\Yoyakuuser;
use App\Models\Yoyakutype;
use App\Models\Yoyakujikan;
use App\Models\WeekdayJikan;
use Illuminate\Database\DatabaseManager;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    private $yoyakubi;

    private $yoyakuuser;
    
    private $yoyakutype;

    private $weekdayJikan;

    private $yoyakujikan;

    private $db;

    public function __construct(
        DatabaseManager $db, 
        Yoyakubi $yoyakubi,
        Yoyakuuser $yoyakuuser,
        Yoyakutype $yoyakutype,
        Yoyakujikan $yoyakujikan, 
        WeekdayJikan $weekdayJikan,
    )
    {
        $this->yoyakubi = $yoyakubi;
        $this->yoyakuuser = $yoyakuuser;
        $this->yoyakutype = $yoyakutype;
        $this->weekdayJikan = $weekdayJikan;
        $this->yoyakujikan = $yoyakujikan;
        $this->db = $db;
 }

    // public function index()
    // {
    //     return view('kanri.junban');
    // }
    /**
     * Kanri Dashboard
     */
    public function yoyaku(Request $request)
    {
        $this->setup();
        $today = Carbon::today()->addDays();
        $lastDate = Carbon::today()->addDays(60);

        $yoyakutype_category = session('yoyakutype_category')?session('yoyakutype_category'):1;
        $yoyakutype = $this->yoyakutype
            ->where('yoyakutype_category', $yoyakutype_category)
            ->get();

        if($request->input('start_date') != ''){
            $today = $request->input('start_date');
        }
        if($request->input('end_date') != ''){
            $lastDate = $request->input('end_date');
        }

        $yoyakuUsers = $this->yoyakuuser
            ->from('yoyakuusers as yu')
            ->join('yoyakujikans as yj', 'yj.id', '=', 'yu.yoyakujikan_id')
            ->join('yoyakubis as yb', 'yb.id', '=', 'yj.yoyakubi_id')
            ->where('yu.is_cancel', '=', '0')
            ->where('yj.yoyakutype_category', '=', $yoyakutype_category)
            ->where('yb.date', '>=', $today)
            ->where('yb.date', '<=', $lastDate);

        if($request->input('yoyakutype_id') > 0){
            $yoyakutype_id = $request->input('yoyakutype_id');
            $yoyakuUsers = $yoyakuUsers->where('yu.yoyakutype_id', $yoyakutype_id);
        }
        $yoyakuUsers = $yoyakuUsers
            ->orderBy('yb.date')
            ->select('yu.*','yb.id as yoyakubi_id', 'yb.title as title')
            ->with(['yoyakujikan', 'yoyakutype'])
            ->get();

        return view('kanri.dashboard')
            ->with('yoyakutype', $yoyakutype)
            ->with('yoyakuUsers', $yoyakuUsers);
    }

    /**
     * Setup calendar date
     */
    public function setup()
    {
        $this->db->beginTransaction();
        $endDate = Carbon::now()->addMonth(4)->endOfMonth()->toDateString();
        if($this->yoyakubi->where('date', $endDate)->exists()){
            return;
        }
        $latestYoyakubi = $this->yoyakubi->orderBy('id','desc')->first();
        if($latestYoyakubi){
            $startDate = Carbon::createFromFormat('Y-m-d', $latestYoyakubi->date)->addDays(1)->toDateString();
        }else{
            $startDate = Carbon::now()->addMonth(-1)->startOfMonth()->toDateString();
        }

        $yoyakubis  = [];
        $shukujitsu = array_keys(
            json_decode(http::get('https://holidays-jp.github.io/api/v1/date.json'), TRUE)
        );
        $period = CarbonPeriod::create($startDate, '1 day', $endDate);  
        foreach ($period as $date) {
            if(in_array($date->format('Y-m-d'),getNationalHolidays())){ //if holiday
                $yoyakubis[] = array(
                    'title' => $date->locale('ja')->format('Y年m月d日').'('.getWeekDayName($date->dayOfWeek).')',
                    'date' => $date->format('Y-m-d'),
                    'is_active' => '0',
                    'description' => in_array($date->format('Y-m-d'),$shukujitsu)?'休診日':'平日',
                    'is_display' => '1'
                );
            }else{
                $yoyakubis[] = array(
                    'title' => $date->locale('ja')->format('Y年m月d日').'('.getWeekDayName($date->dayOfWeek).')',
                    'date' => $date->format('Y-m-d'),
                    'is_active'  => getWeekDayName($date->dayOfWeek, 'is_active'),
                    'description' => in_array($date->format('Y-m-d'),$shukujitsu)?'休診日':'平日',
                    'is_display' => '1'
                );
                
            }

        }

        $this->yoyakubi->upsert($yoyakubis, ['date', 'is_active']);

        $yoyakubis_new = $this->yoyakubi
            ->whereBetween('date', 
                array($startDate, $endDate)
            )
            ->where('is_active', '1')
            ->get();

        $yoyakujikans = [];
        
        foreach($yoyakubis_new as $yb) {
            $weekday_index = getWeekIndexByDate($yb->date);
            $weekdayJikan = $this->weekdayJikan->where('weekday_index', $weekday_index)
                ->where('yoyakutype_category', '1')->get();
            if($weekdayJikan->count()){
                foreach($weekdayJikan as $value){
                    $yoyakujikans[] = array(
                        'yoyakubi_id' => $yb->id,
                        'start_time' => $value->start_time,
                        'end_time' => $value->end_time,
                        'yoyakutype_category' => '1'
                    );
                    
                }
            }
        }
        
        if(!empty($yoyakujikans)){
            $this->yoyakujikan->upsert($yoyakujikans, ['yoyakubi_id', 'start_time', 'end_time', 'yoyakutype_category'],['start_time','end_time']);
        }
        $this->db->commit();

        return;
    }

}
