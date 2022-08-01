<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFulfilledToOrderArchive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_archive', function (Blueprint $table) {
            $table->foreignId('archived_by')->nullable()->references('id')->on('users');//
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_archive', function (Blueprint $table) {
            $table->dropColumn('archived_by');//
        });
    }
}
