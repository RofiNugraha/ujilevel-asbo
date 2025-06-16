<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AsboDBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'rofinugraha03@gmail.com',
            'usertype' => 'admin',
            'phone' => '0895323066530',
            'address' => 'Dramaga H. Abbas',
            'image' => '',
            'nama_lengkap' => 'Rofi Nugraha',
            'password' => Hash::make('ROFINUGRAHA05'),
        ]);
    }
}