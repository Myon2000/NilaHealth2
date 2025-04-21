<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name'=>'superadmin',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('bismilah'),
            'role'=>'admin',
            'last_login'=>null,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
    }
}
