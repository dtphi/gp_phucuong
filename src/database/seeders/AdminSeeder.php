<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class AdminSeeder
 *
 * @package Database\Seeders
 */
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->truncate();

        $now = Carbon::now();
        $data = [
            [
                'name'       => 'Admin',
                'email'      => 'admin@mail.com',
                'password'   => Hash::make('password'),
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        for ($idx = 1; $idx < 10; $idx++) {
            $no = sprintf('%02d', $idx);
            $data[] = [
                'name'       => "Admin${no}",
                'email'      => "admin.${no}@mail.com",
                'password'   => Hash::make('password'),
                'created_at' => $now,
                'updated_at' => $now
            ];
        }
        DB::table('admins')->insert($data);
    }
}
