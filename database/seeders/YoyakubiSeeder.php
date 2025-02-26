<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Yoyakubi;
use Illuminate\Support\Facades\DB;

class YoyakubiSeeder extends Seeder
{
    private $yoyakubi;

    public function __construct(Yoyakubi $yoyakubi){
        $this->yoyakubi = $yoyakubi;
    }

    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $this->yoyakubi->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
    }
}
