<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateStoresTable
 */
class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function(Blueprint $table) {
            $table->id()->comment('ID');
            $table->foreignId('sale_rep_id')->comment('営業担当者ID');
            $table->string('code')->unique()->comment('販売店コード');
            $table->string('name')->comment('販売店名');
            $table->string('rep_last_name')->nullable()->comment('代表者姓');
            $table->string('rep_first_name')->nullable()->comment('代表者名');
            $table->string('rep_last_name_kana')->nullable()->comment('代表者セイ');
            $table->string('rep_first_name_kana')->nullable()->comment('代表者メイ');
            $table->string('phone_number')->comment('電話番号');
            $table->string('fax_number')->nullable()->comment('FAX番号');
            $table->string('address')->comment('住所');
            $table->string('main_email')->nullable()->comment('メインメールアドレス');
            $table->string('sub_email1')->nullable()->comment('サブメールアドレス1');
            $table->string('sub_email2')->nullable()->comment('サブメールアドレス2');
            $table->string('sub_email3')->nullable()->comment('サブメールアドレス3');
            $table->string('sub_email4')->nullable()->comment('サブメールアドレス4');
            $table->text('memo')->nullable()->comment('メモ');
            $table->string('password')->comment('パスワード（暗号化して保存）');
            $table->timestamp('requested_reissuance_at')->nullable()->comment('パスワード再発行依頼日時');
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
        Schema::dropIfExists('stores');
    }
}
