<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Config;
use Illuminate\Support\Facades\DB;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (\Schema::hasTable('site_settings')) {
            $mail = DB::table('site_settings')->first();
            if ($mail) //checking if table is not empty
            {
                $config = array(
                    'transport' => $mail->mail_mailer,
                    'url' => env('MAIL_URL'),
                    'host' => $mail->mail_host,
                    'port' => $mail->mail_port,
                    'encryption' => $mail->mail_encryption,
                    'username' => $mail->mail_username,
                    'password' =>  $mail->mail_password,
                    'timeout' => null,
                    'local_domain' => env('MAIL_EHLO_DOMAIN'),
                );
                Config::set('mail.mailers.smtp', $config);

                //configure line messaging api
                $config = array(
                    'channel_id' => $mail->channel_id,
                    'channel_secret' => $mail->channel_secret,
                    'channel_token' => $mail->channel_token,
                    'liff_channel_id' => $mail->liff_channel_id,
                    'liffId' => $mail->liffId,
                    'liffId_waiting' => $mail->liffId_waiting,
                );
                Config::set('services.line.message', $config);
                Config::set('services.yoyaku_url', $mail->yoyaku_url);
                Config::set('services.yoyaku_content_line', $mail->yoyaku_content_line);
            }
        }
    }
}
