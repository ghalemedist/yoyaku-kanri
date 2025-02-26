<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WeekdayJikan extends Model
{
    use HasFactory;

    protected $fillable = [
        'weekday_index', 
        'start_time', 
        'end_time',
        'type'
    ];

    public function getFormatStartTimeAttribute()
    {
        $dt = Carbon::create($this->start_time);
        return $dt->format("h:i");
    }

    public function getFormatEndTimeAttribute()
    {
        $dt = Carbon::create($this->end_time);
        return $dt->format("h:i");
    }

    public function getFormatTimeAttribute()
    {
        $st = Carbon::create($this->start_time);
        $et = Carbon::create($this->end_time);
        return $st->format("h:i").'～'.$et->format("h:i");
    }
}
