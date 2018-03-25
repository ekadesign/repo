<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForumMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_messages', function (Blueprint $table){
            $table->increments('id');
            $table->longText('text');
            $table->integer('parent_id')->unsigned()->default(NULL);
            $table->integer('topic_id')->unsigned();
            $table->foreign('topic_id')->references('id')->on('forum_topics')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->string('replys')->nullable();
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
        Schema::table('forum_messages', function (Blueprint $table){
            $table->dropForeign(['topic_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('forum_messages');
    }
}
