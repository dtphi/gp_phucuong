<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('newsname', 200)->nullable();
            $table->bigInteger('newsgroupid')->nullable();
            $table->string('newsids', 200)->nullable();
            $table->string('newsids2', 200)->nullable();
            $table->string('context', 200)->nullable();
            $table->string('context1', 200)->nullable();
            $table->string('context2', 200)->nullable();
            $table->string('context3', 200)->nullable();
            $table->string('context4', 200)->nullable();
            $table->string('context5', 200)->nullable();
            $table->string('picture', 200)->nullable();
            $table->string('picture1', 200)->nullable();
            $table->string('picture2', 200)->nullable();
            $table->string('picture3', 200)->nullable();
            $table->string('picture4', 200)->nullable();
            $table->string('picture5', 200)->nullable();
            $table->string('picture6', 200)->nullable();
            $table->string('picture7', 200)->nullable();
            $table->string('picture8', 200)->nullable();
            $table->string('picture9', 200)->nullable();
            $table->string('text', 200)->nullable();
            $table->string('text1', 200)->nullable();
            $table->string('text2', 200)->nullable();
            $table->string('text3', 200)->nullable();
            $table->string('text4', 200)->nullable();
            $table->string('text5', 200)->nullable();
            $table->string('text6', 200)->nullable();
            $table->string('text7', 200)->nullable();
            $table->string('text8', 200)->nullable();
            $table->string('text9', 200)->nullable();
            $table->string('productids', 200)->nullable();
            $table->string('productids2', 200)->nullable();
            $table->string('status', 200)->nullable();
            $table->string('description', 200)->nullable();
            $table->string('newslink', 200)->nullable();
            $table->string('newsnamenomark', 200)->nullable();
            $table->integer('vote')->nullable();
            $table->integer('visit')->nullable();
            $table->string('tag', 200)->nullable();
            $table->string('metatitle', 200)->nullable();
            $table->string('metadescription', 200)->nullable();
            $table->string('metakeyword', 200)->nullable();
            $table->integer('toplevel')->nullable();
            $table->timestamp('createdate')->nullable();
            $table->string('newsname2', 200)->nullable();
            $table->string('newstype', 200)->nullable();
            $table->integer('slideid')->nullable();
            $table->integer('slideid2')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('newsgroup_id')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
