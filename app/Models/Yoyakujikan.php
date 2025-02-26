<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Yoyakubi;
use App\Models\Yoyakuuser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class Yoyakujikan extends Model
{
    use HasFactory;

    protected $fillable = [
        'yoyakubi_id', 
        'start_time',
        'end_time',
        'is_active',
        'type',
        'is_premium'
    ];

    protected $appends = ['format_time', 'yoyaku_type', 'count_user', 'start_time_only', 'format_start_time'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('ordering', function (Builder $builder) {
            $builder->orderBy('is_premium')->orderBy('start_time');
        });
    }
    
    public function yoyakubi()
    {
        return $this->belongsTo(Yoyakubi::class);
    }

    public function Yoyakuuser()
    {
        return $this->hasMany(Yoyakuuser::class)->where('is_cancel','0')->where('yoyaku_status','1');
    }

    public function getFormatTimeAttribute()
    {
        $st = Carbon::create($this->start_time);
        $et = Carbon::create($this->end_time);
        return $st->format("H:i").'～'.$et->format("H:i");
    }

    public function getStartTimeOnlyAttribute()
    {
        $st = Carbon::create($this->start_time);
        return $st->format("H:i").'～';
    }

    public function getYoyakuTypeAttribute()
    {
        return ($this->type == 1)?'診察予約':'トリミング＆シャンプー予約';
    }

    public function getCountUserAttribute()
    {
        $res = $this->hasMany(Yoyakuuser::class)->where('is_cancel','0')->where('yoyaku_status','1')->count('id');
        return $res;
    }

    public function getFormatStartTimeAttribute()
    {
        $st = Carbon::create($this->start_time);
        return $st->format("H:i");
    }

    /**
     * Get all of the countYoyaku for the ScheduleTimeslot
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function yoyakuActive()
    {
        return $this->hasMany(Yoyakuuser::class)
            ->where('is_cancel', '0');
    }

}
