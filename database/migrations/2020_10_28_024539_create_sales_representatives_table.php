<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateSalesRepresentativesTable
 */
class CreateSalesRepresentativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_representatives', function(Blueprint $table) {
            $table->id()->comment('ID');
            $table->string('employee_number')->comment('担当者コード');
            $table->string('last_name')->comment('姓');
            $table->string('first_name')->comment('名');
            $table->string('last_name_kana')->comment('セイ');
            $table->string('first_name_kana')->comment('メイ');
            $table->string('phone_number')->comment('電話番号');
            $table->string('main_email')->unique()->comment('メインメールアドレス');
            $table->string('sub_email1')->nullable()->comment('サブメールアドレス1');
            $table->string('sub_email2')->nullable()->comment('サブメールアドレス2');
            $table->string('sub_email3')->nullable()->comment('サブメールアドレス3');
            $table->string('sub_email4')->nullable()->comment('サブメールアドレス4');
            $table->string('password')->comment('パスワード');
            $table->timestamp('reissued_at')->nullable()->comment('パスワード再発行日時');
            $table->timestamp('last_logged_in_at')->nullable()->comment('最終ログイン日時');
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
        Schema::dropIfExists('sales_representatives');
    }
}
