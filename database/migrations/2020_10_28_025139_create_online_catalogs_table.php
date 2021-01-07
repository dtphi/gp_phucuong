<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateOnlineCatalogsTable
 */
class CreateOnlineCatalogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_catalogs', function(Blueprint $table) {
            $table->id()->comment('ID');
            $table->string('manufacturer_name')->comment('メーカー名');
            $table->string('manufacturer_image')->comment('メーカー画像');
            $table->text('url')->comment('URL');
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
        Schema::dropIfExists('online_catalogs');
    }
}
