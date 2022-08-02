<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWriteoffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('writeoffs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignID('user_id')->references('id')->on('users');
            $table->longText('description');
            $table->integer('amount');
            $table->foreignId('item_id')->references('id')->on('items');
            $table->foreignId('storage_space_id')->references('id')->on('storage_spaces');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('writeoffs');
    }
}
