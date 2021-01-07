<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class ProdRepresentativeSeeder
 *
 * @package Database\Seeders
 */
class ProdRepresentativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sales_representatives')->truncate();

        $src = [
            [ 3073, '福島', '弘之', 'フクシマ', 'ヒロユキ', '080-5896-1677', 'fukushima.hiroyuki@nittoh-e.co.jp', 'n150210fukushima.hiroyuki@softbank.ne.jp', '', '', '', 'rx5bc1p7' ],
            [ 1002, '中村', '貞三', 'ナカムラ', 'テイゾウ', '080-5896-1590', 'nakamura.teizou@nittoh-e.co.jp', 'n150210nakamura.teizou@softbank.ne.jp', '', '', '', 'g63d5qt3' ],
            [ 1079, '金子', '剣', 'カネコ', 'ツルギ', '080-5896-1581', 'kaneko.tsurugi@nittoh-e.co.jp', 'n150210kaneko.tsurugi@softbank.ne.jp', '', '', '', 'ctmpx6ib' ],
            [ 3314, '横山', '正己', 'ヨコヤマ', 'マサキ', '080-5896-1596', 'yokoyama.masaki@nittoh-e.co.jp', 'n150210yokoyama.masaki@softbank.ne.jp', '', '', '', 'bti805qe' ],
            [ 1042, '渡辺', '明弘', 'ワタナベ', 'アキヒロ', '080-5896-1709', 'watanabe.akihiro@nittoh-e.co.jp', 'n150210watanabe.akihiro@softbank.ne.jp', '', '', '', '8k87ay69' ],
            [ 3018, '大野', '和徳', 'オオノ', 'カズノリ', '080-5896-1584', 'ohno.kazunori@nittoh-e.co.jp', 'n150210ohno.kazunori@softbank.ne.jp', '', '', '', 'hgeyaabl' ],
            [ 3122, '藤島', '潤司', 'フジシマ', 'ジュンジ', '080-5896-1612', 'fujishima.junji@nittoh-e.co.jp', 'n150210watanabe.junji@softbank.ne.jp', '', '', '', '7r4kp6pb' ],
            [ 4238, '門馬', '光司', 'モンマ', 'コウジ', '080-5896-1615', 'monma.kouji@nittoh-e.co.jp', 'n150210monma.kouji@softbank.ne.jp', '', '', '', 'zve8hnyb' ],
            [ 8627, '佐久間', '均', 'サクマ', 'ヒトシ', '080-5896-1687', 'sakuma.hitoshi@nittoh-e.co.jp', 'n150210sakuma.hitoshi@softbank.ne.jp', '', '', '', 'xr2ld2j8' ],
            [ 1208, '中村', '敏也', 'ナカムラ', 'トシヤ', '080-6849-9737', 'nakamura.toshiya@nittoh-e.co.jp', 'n150210nakamura.toshiya@softbank.ne.jp', '', '', '', '5cvoat5z' ],
            [ 5006, '金井', '智昭', 'カナイ', 'トモアキ', '080-5896-1634', 'kanai.tomoaki@nittoh-e.co.jp', 'n150210kanai.tomoaki@softbank.ne.jp', '', '', '', 'g9otrkyx' ],
            [ 3015, '岡部', '俊徳', 'オカベ', 'トシノリ', '080-5896-1585', 'okabe.toshinori@nittoh-e.co.jp', 'n150210okabe.toshinori@softbank.ne.jp', '', '', '', '8bmbz1t5' ],
            [ 8033, '白鳥', '健人', 'シラトリ', 'ケント', '080-5896-1630', 'shiratori.kento@nittoh-e.co.jp', 'n150210shiratori.kento@softbank.ne.jp', '', '', '', 'q78usjrw' ],
            [ 6204, '鴨志田', '渉', 'カモシタ', 'ワタル', '080-5896-1663', 'kamoshita.wataru@nittoh-e.co.j', 'n150210kamoshita.wataru@softbank.ne.jp', '', '', '', 'ebyyml5z' ],
            [ 2007, '本宮', '正人', 'モトミヤ', 'マサヒト', '080-5896-1560', 'motomiya.masahito@nittoh-e.co.jp', 'n150210motomiya.masahito@softbank.ne.jp', '', '', '', '7u8wf83h' ],
            [ 1315, '星', '政徳', 'ホシ', 'マサノリ', '080-5896-1605', 'hoshi.masanori@nittoh-e.co.jp', 'n150210hoshi.masanori@softbank.ne.jp', '', '', '', '2fnsfy1r' ]
        ];
        $now = Carbon::now();
        $data = [];

        foreach ($src as $item) {
            $data[] = [
                'employee_number' => $item[0],
                'last_name'       => $item[1],
                'first_name'      => $item[2],
                'last_name_kana'  => $item[3],
                'first_name_kana' => $item[4],
                'phone_number'    => $item[5],
                'main_email'      => $item[6],
                'sub_email1'      => $item[7] ? $item[7] : null,
                'sub_email2'      => $item[8] ? $item[8] : null,
                'sub_email3'      => $item[9] ? $item[9] : null,
                'sub_email4'      => $item[10] ? $item[10] : null,
                'password'        => Hash::make($item[11]),
                'created_at'      => $now,
                'updated_at'      => $now
            ];
        }
        DB::table('sales_representatives')->insert($data);
    }
}
