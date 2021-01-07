<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPasswordLastChangedColumnForUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->timestamp('password_last_changed_at')->nullable();
        });

        Schema::table('sales_representatives', function (Blueprint $table) {
            $table->timestamp('password_last_changed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('password_last_changed_at');
        });

        Schema::table('sales_representatives', function (Blueprint $table) {
            $table->dropColumn('password_last_changed_at');
        });
    }
}
