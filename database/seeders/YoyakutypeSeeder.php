<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Yoyakutype;
use Illuminate\Support\Facades\DB;

class YoyakutypeSeeder extends Seeder
{
    private $yoyakutype;

    public function __construct(Yoyakutype $yoyakutype){
        $this->yoyakutype = $yoyakutype;
    }

    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $this->yoyakutype->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        $this->yoyakutype->create([
            'title' => '診察',
            'yoyakutype_category' => '1'
        ]);
        $this->yoyakutype->create([
            'title' => 'その他',
            'yoyakutype_category' => '1'
        ]);

        
    }
}
