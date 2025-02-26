<?php
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

function getYoyakubiData($days)
{
    $dt = Carbon::today()->addDays($days);
    $date = $dt->format('Y-m-d');
    if(in_array($date,getNationalHolidays())){ //if holiday
        $data = array(
            'title' => $dt->locale('ja')->format('Y年m月d日').'('.getWeekDayName($dt->dayOfWeek).')',
            'date' => $dt->format('Y-m-d'),
            'description'  => '休診日',
            'is_active'  => '0',
            'is_display' => '1'
        );
    }else{
        $data = array(
            'title' => $dt->locale('ja')->format('Y年m月d日').'('.getWeekDayName($dt->dayOfWeek).')',
            'date' => $dt->format('Y-m-d'),
            'description'  => getWeekDayName($dt->dayOfWeek, 'description'),
            'is_active'  => getWeekDayName($dt->dayOfWeek, 'is_active'),
            'is_display' => '1'
        );
    }
    return $data;
}

function getWeekDayName($index, $key = 'title') {
    $weekDays = getWeekDaysInfo();
    $res = array_search($index, array_column($weekDays, 'index'));
    return $weekDays[$res][$key];
}

function getAddDays($day)
{
    return Carbon::today()->addDays($day);
}

function getWeekIndexByDate($date)
{
    $dt = Carbon::createFromDate($date);
    return $dt->format('w');
    
}

function getWeekDaysInfo()
{
    $data = array(
        ['index'=> '0', 'title' => '日', 'is_active' => '0', 'description' => '休診日'],
        ['index'=> '1', 'title' => '月', 'is_active' => '1', 'description' => '平日'],
        ['index'=> '2', 'title' => '火', 'is_active' => '1', 'description' => '平日'],
        ['index'=> '3', 'title' => '水', 'is_active' => '1', 'description' => '平日'],
        ['index'=> '4', 'title' => '木', 'is_active' => '0', 'description' => '休診日'],
        ['index'=> '5', 'title' => '金', 'is_active' => '1', 'description' => '平日'],
        ['index'=> '6', 'title' => '土', 'is_active' => '1', 'description' => '平日'],
    );
    return $data;
}

function countUsersByYoyakubiId($yoakubi_id, $type = 1)
{
    $total_users = DB::table('yoyakuusers as yu')
        ->join('yoyakujikans as yj', 'yu.yoyakujikan_id', '=', 'yj.id')
        ->join('yoyakubis as yb', 'yj.yoyakubi_id', '=', 'yb.id')
        ->where('yj.type', $type)
        ->where('yb.id', $yoakubi_id)
        ->where('yu.is_cancel', '0')
        ->select('yu.*')
        ->count('yu.id');

    return $total_users;
}

function countActiveYoyakujikanByYoyakubiId($yoakubi_id, $type = 1)
{
    $total_users = DB::table('yoyakujikans as yj')
        ->join('yoyakubis as yb', 'yj.yoyakubi_id', '=', 'yb.id')
        ->where('yb.id', $yoakubi_id)
        ->where('yj.type', $type)
        ->where('yj.is_active', '1')
        ->select('yj.id')
        ->count('yj.id');

    return $total_users;
}

function getNationalHolidays()
{
    $response = json_decode(http::get('https://holidays-jp.github.io/api/v1/date.json'), TRUE);
    return array_keys($response);
}

function getYoyakuType($type)
{
    return ($type == 1)?'診察予約':'トリミング＆シャンプー予約';
}