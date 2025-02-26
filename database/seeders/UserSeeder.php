<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $this->user->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        $this->user->create([
            'id' => 1,
            'name' => 'ガレ',
            'email' => 'ghale.medist@gmail.com',
            'password' => Hash::make('Medhist6030'),
        ]);
    }
}
