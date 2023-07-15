<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('status', 100)->default('active');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->String('item_code', 100)->index();
            $table->String('item_number', 100)->index();
            $table->index(['item_code', 'item_number'])->unique();
            $table->string('category', 100)->index();
            $table->string('brand', 100)->index();
            $table->string('item_name', 100)->index();
            $table->integer('list_price')->index();
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
        Schema::dropIfExists('items');
    }
}
