<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Yoyakujikan;
use App\Models\Yoyakutype;
use Carbon\Carbon;

class Yoyakuuser extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'token_id',
        'is_cancel',
        'yoyaku_status'
    ];

    public function yoyakujikan()
    {
        return $this->belongsTo(Yoyakujikan::class);
    }

    public function yoyakutype()
    {
        return $this->belongsTo(Yoyakutype::class);
    }

    public function getFormatCreatedAtAttribute()
    {
        $st = Carbon::create($this->created_at);
        return $st->format("Y/m/d H:i");
    }

    public function getFormatYoyakuStatusAttribute()
    {
        return ($this->yoyaku_status == 1)?'<button type="button" class="btn btn-success">アクティブ</button>'
            :'<button type="button" class="btn btn-danger">キャンセル</button>';
    }

}
