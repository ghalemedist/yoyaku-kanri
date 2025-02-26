<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\DB;

class SiteSettingSeeder extends Seeder
{
    private $siteSetting;
    
    public function __construct(SiteSetting $siteSetting)
    {
        $this->siteSetting = $siteSetting;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $this->siteSetting->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        $this->siteSetting->create([
            'id' => 1,
            'mail_mailer' => 'SMTP',
            'mail_host' => 'pop.lolipop.jp',
            'mail_port' => '465',
            'mail_encryption' => 'SSL',
            'mail_username' => 'ghale@medist.jp',
            'mail_password' => '1423-Medhist',
            'channel_id' => '1661487591',
            'channel_secret' => '22c6d66be85469380b9873b8a1357bda',
            'channel_token' => 'eyJhbGciOiJIUzI1NiJ9.ppkUe8IikXHtvJIhslZ4EfRbS05tOKT0xUUOqefuMfM2jjbRIWOXpnMjJ3I9toYUCn9-Qsw6YvfUNNV5Wz-__8uAqCRWKuZ_QzlQ9duTxARd2lTkLn1FNYW3guKmQRrs.dFAot-BD7RRwZMddN1-YJcOKri955IQ1jfcCJVCsu1U',
            'liffId' => '1661488096-GK0Y43Oq',
            'liff_channel_id' => '1661488096',
            'yoyaku_url' => 'http://localhost:5173'
        ]);
    }
}
