<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThirdpartyToTablePosProductItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pos_product_item', function (Blueprint $table) {
            $table->integer('thirdparty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pos_product_item', function (Blueprint $table) {
            $table->dropColumn('thirdparty');
        });
    }
}
