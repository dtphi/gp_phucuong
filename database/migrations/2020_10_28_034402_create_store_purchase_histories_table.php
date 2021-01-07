<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateStorePurchaseHistoriesTable
 */
class CreateStorePurchaseHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_purchase_histories', function(Blueprint $table) {
            $table->id()->comment('ID');
            $table->string('store_code')->comment('販売店コード');
            $table->string('store_name')->comment('販売店名');
            $table->date('order_date')->comment('発注日');
            $table->string('manufacturer_name')->comment('メーカー名');
            $table->string('model')->comment('型式');
            $table->string('product_name')->comment('品名');
            $table->unsignedInteger('unit_price')->default(0)->comment('単価');
            $table->integer('quantity')->default(0)->comment('数量');
            $table->timestamp('deleted_at')->nullable()->comment('削除日時');
            $table->timestamp('updated_at')->useCurrent()->comment('更新日時');
            $table->timestamp('created_at')->useCurrent()->comment('作成日時');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_purchase_histories');
    }
}
