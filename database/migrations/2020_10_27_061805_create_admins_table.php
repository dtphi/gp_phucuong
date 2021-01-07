<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateAdminsTable
 */
class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function(Blueprint $table) {
            $table->id()->comment('ID');
            $table->string('name')->default('Admin')->comment('管理者名');
            $table->string('email')->unique()->comment('メールアドレス');
            $table->string('password')->comment('パスワード（暗号化して保存）');
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
        Schema::dropIfExists('admins');
    }
}
