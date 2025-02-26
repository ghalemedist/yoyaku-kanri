<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WeekdayJikan;
use Illuminate\Support\Facades\DB;

class WeekdayJikanSeeder extends Seeder
{
    private $weekDayJikan;

    public function __construct(WeekdayJikan $weekDayJikan){
        $this->weekDayJikan = $weekDayJikan;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $this->weekDayJikan->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        //診察時間
        //月曜日
        $this->weekDayJikan->create([
            'weekday_index' => '1',
            'start_time' => '9:30',
            'end_time' => '10:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '1',
            'start_time' => '10:00',
            'end_time' => '10:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '1',
            'start_time' => '10:30',
            'end_time' => '11:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '1',
            'start_time' => '11:00',
            'end_time' => '11:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '1',
            'start_time' => '11:30',
            'end_time' => '12:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '1',
            'start_time' => '15:00',
            'end_time' => '15:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '1',
            'start_time' => '15:30',
            'end_time' => '16:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '1',
            'start_time' => '16:00',
            'end_time' => '16:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '1',
            'start_time' => '16:30',
            'end_time' => '17:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '1',
            'start_time' => '17:00',
            'end_time' => '17:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '1',
            'start_time' => '17:30',
            'end_time' => '18:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '1',
            'start_time' => '18:00',
            'end_time' => '18:30',
            'yoyakutype_category' => '1',
        ]);

        //火曜日
        $this->weekDayJikan->create([
            'weekday_index' => '2',
            'start_time' => '9:30',
            'end_time' => '10:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '2',
            'start_time' => '10:00',
            'end_time' => '10:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '2',
            'start_time' => '10:30',
            'end_time' => '11:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '2',
            'start_time' => '11:00',
            'end_time' => '11:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '2',
            'start_time' => '11:30',
            'end_time' => '12:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '2',
            'start_time' => '15:00',
            'end_time' => '15:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '2',
            'start_time' => '15:30',
            'end_time' => '16:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '2',
            'start_time' => '16:00',
            'end_time' => '16:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '2',
            'start_time' => '16:30',
            'end_time' => '17:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '2',
            'start_time' => '17:00',
            'end_time' => '17:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '2',
            'start_time' => '17:30',
            'end_time' => '18:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '2',
            'start_time' => '18:00',
            'end_time' => '18:30',
            'yoyakutype_category' => '1',
        ]);

        //水曜日
        $this->weekDayJikan->create([
            'weekday_index' => '3',
            'start_time' => '9:30',
            'end_time' => '10:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '3',
            'start_time' => '10:00',
            'end_time' => '10:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '3',
            'start_time' => '10:30',
            'end_time' => '11:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '3',
            'start_time' => '11:00',
            'end_time' => '11:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '3',
            'start_time' => '11:30',
            'end_time' => '12:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '3',
            'start_time' => '15:00',
            'end_time' => '15:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '3',
            'start_time' => '15:30',
            'end_time' => '16:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '3',
            'start_time' => '16:00',
            'end_time' => '16:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '3',
            'start_time' => '16:30',
            'end_time' => '17:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '3',
            'start_time' => '17:00',
            'end_time' => '17:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '3',
            'start_time' => '17:30',
            'end_time' => '18:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '3',
            'start_time' => '18:00',
            'end_time' => '18:30',
            'yoyakutype_category' => '1',
        ]);

        // //木曜日 => 休診日

        //金曜日
        $this->weekDayJikan->create([
            'weekday_index' => '5',
            'start_time' => '9:30',
            'end_time' => '10:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '5',
            'start_time' => '10:00',
            'end_time' => '10:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '5',
            'start_time' => '10:30',
            'end_time' => '11:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '5',
            'start_time' => '11:00',
            'end_time' => '11:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '5',
            'start_time' => '11:30',
            'end_time' => '12:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '5',
            'start_time' => '15:00',
            'end_time' => '15:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '5',
            'start_time' => '15:30',
            'end_time' => '16:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '5',
            'start_time' => '16:00',
            'end_time' => '16:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '5',
            'start_time' => '16:30',
            'end_time' => '17:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '5',
            'start_time' => '17:00',
            'end_time' => '17:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '5',
            'start_time' => '17:30',
            'end_time' => '18:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '5',
            'start_time' => '18:00',
            'end_time' => '18:30',
            'yoyakutype_category' => '1',
        ]);

        // 土曜日
        $this->weekDayJikan->create([
            'weekday_index' => '6',
            'start_time' => '9:30',
            'end_time' => '10:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '6',
            'start_time' => '10:00',
            'end_time' => '10:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '6',
            'start_time' => '10:30',
            'end_time' => '11:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '6',
            'start_time' => '11:00',
            'end_time' => '11:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '6',
            'start_time' => '11:30',
            'end_time' => '12:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '6',
            'start_time' => '12:00',
            'end_time' => '12:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '6',
            'start_time' => '12:30',
            'end_time' => '13:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '6',
            'start_time' => '13:00',
            'end_time' => '13:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '6',
            'start_time' => '13:30',
            'end_time' => '14:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '6',
            'start_time' => '14:00',
            'end_time' => '14:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '6',
            'start_time' => '14:30',
            'end_time' => '15:00',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '6',
            'start_time' => '15:00',
            'end_time' => '15:30',
            'yoyakutype_category' => '1',
        ]);
        $this->weekDayJikan->create([
            'weekday_index' => '6',
            'start_time' => '15:30',
            'end_time' => '16:00',
            'yoyakutype_category' => '1',
        ]);
        //日曜日＝＞休診日

        //type2
         //月曜日
         $this->weekDayJikan->create([
            'weekday_index' => '1',
            'start_time' => '9:30',
            'end_time' => '12:00',
            'yoyakutype_category' => '2',
        ]);

        //火曜日
        $this->weekDayJikan->create([
            'weekday_index' => '2',
            'start_time' => '9:30',
            'end_time' => '12:00',
            'yoyakutype_category' => '2',
        ]);
       
        //水曜日
        $this->weekDayJikan->create([
            'weekday_index' => '3',
            'start_time' => '9:30',
            'end_time' => '12:00',
            'yoyakutype_category' => '2',
        ]);

        // 木曜日 => 休診日
        
        //金曜日
        $this->weekDayJikan->create([
            'weekday_index' => '5',
            'start_time' => '9:30',
            'end_time' => '12:00',
            'yoyakutype_category' => '2',
        ]);

        // 土曜日
        $this->weekDayJikan->create([
            'weekday_index' => '6',
            'start_time' => '9:30',
            'end_time' => '12:00',
            'yoyakutype_category' => '2',
        ]);
        //日曜日＝＞休診日
    }
}
