<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class CatalogSeeder
 *
 * @package Database\Seeders
 */
class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('online_catalogs')->truncate();

        $now = Carbon::now();
        $data = [
            [
                'manufacturer_name'  => 'リンナイ株式会社',
                'manufacturer_image' => 'rinnai.png',
                'url'                => 'https://rinnai.jp/catalog_download',
                'created_at'         => $now,
                'updated_at'         => $now
            ],
            [
                'manufacturer_name'  => '株式会社パロマ',
                'manufacturer_image' => 'noritz.png',
                'url'                => 'https://noritz.mediapress-net.com/iportal/CatalogSearch.do?method=catalogSearchByAnyCategories&volumeID=NRZ50001&categoryID=1051140000&designID=NRZD001',
                'created_at'         => $now,
                'updated_at'         => $now
            ],
            [
                'manufacturer_name'  => '株式会社ノーリツ',
                'manufacturer_image' => 'harman.png',
                'url'                => 'https://www.harman.co.jp/catalog',
                'created_at'         => $now,
                'updated_at'         => $now
            ],
            [
                'manufacturer_name'  => '株式会社ハーマン',
                'manufacturer_image' => 'paloma.png',
                'url'                => 'https://www.paloma.co.jp/product/catalog/index.html',
                'created_at'         => $now,
                'updated_at'         => $now
            ],
            [
                'manufacturer_name'  => 'パーパス株式会社',
                'manufacturer_image' => 'purpose.png',
                'url'                => 'https://www.purpose.co.jp/aftersupport/catalog',
                'created_at'         => $now,
                'updated_at'         => $now
            ]
        ];
        DB::table('online_catalogs')->insert($data);
    }
}
