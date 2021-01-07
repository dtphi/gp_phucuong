<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateMessagesTable
 */
class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function(Blueprint $table) {
            $table->id()->comment('ID');
            $table->foreignId('store_id')->comment('販売店ID');
            $table->tinyInteger('sender_type')->default(1)->comment('送信者種別（1:販売店、2:営業担当者、3:システム）');
            $table->foreignId('sender_id')->comment('送信者ID（sender_type = 1(販売店)、3(システム)の場合は0）');
            $table->text('contents')->nullable()->comment('内容');
            $table->text('file')->nullable()->comment('ファイル');
            $table->text('meta')->nullable()->comment('メタ');
            $table->text('reply')->nullable()->comment('返信');
            $table->unsignedTinyInteger('can_join')->default(1)->comment('0: can not join, 1: can join');
            $table->timestamp('sent_at')->useCurrent()->comment('送信日時');
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
        Schema::dropIfExists('messages');
    }
}
