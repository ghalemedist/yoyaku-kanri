<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'mail_mailer',
        'mail_host',
        'mail_port',
        'mail_encryption',
        'mail_username',
        'mail_password',
        'channel_id',
        'channel_secret',
        'channel_token',
        'liffId',
        'liffId_waiting',
        'liff_channel_id',
        'yoyaku_url',
        'yoyaku_date',
        'yoyaku_title',
        'yoyaku_content',
        'yoyaku_content_email',
        'yoyaku_content_line',
        'yoyaku_title_premium',
        'yoyaku_content_premium',
    ];
}