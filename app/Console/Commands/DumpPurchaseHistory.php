<?php

namespace App\Console\Commands;

use App\Models\Catalog;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Class DumpPurchaseHistory
 *
 * @package Console\Commands
 */
class DumpPurchaseHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dump:purchase_history {--store_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate dump data for purchase history';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data   = [];
        $models = ['MODEL_1', 'MODEL_2', 'MODEL_3', 'MODEL_4', 'MODEL_5'];

        $storeID = $this->option('store_id') ?? 1;

        $store = Store::where('id', $storeID)->first();

        for ($i = 1; $i <= 1000; $i++) {        
            $data[] = [
                'store_code'        => $store->code,
                'store_name'        => $store->name,
                'manufacturer_name' => Catalog::inRandomOrder()->first()->manufacturer_name,
                'order_date'        => Carbon::now()->subDays(floor($i/2)),
                'model'             => $models[array_rand($models)],
                'product_name'      => "PRODUCT_$i",
                'unit_price'        => mt_rand(10, 100) * 1000 + mt_rand(0, 999),
                'quantity'          => mt_rand(1, 10),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ];
        }
        
        DB::table('store_purchase_histories')->insert($data);
    }
}
