<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class ProdAdminSeeder
 *
 * @package Database\Seeders
 */
class ProdAdminSeeder extends Seeder
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
                'name'       => '小林 正樹',
                'email'      => 'kobayashi.masaki@nittoh-e.co.jp',
                'password'   => Hash::make('aDAc3TUN'),
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];
        DB::table('admins')->insert($data);
    }
}
