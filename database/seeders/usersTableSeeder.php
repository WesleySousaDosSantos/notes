<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class usersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'email' => 'teste@gmail',
                'password' => bcrypt('12345678'),
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'email' => 'teste2@gmail',
                'password' => bcrypt('12345678'),
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'email' => 'teste3@gmail',
                'password' => bcrypt('12345678'),
                'created_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
