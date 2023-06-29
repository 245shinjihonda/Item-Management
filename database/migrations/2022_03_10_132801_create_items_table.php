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
            $table->integer('cat-number')->index();
            $table->integer('item-number')->index();
            $table->index(['cat-number', 'item-number'])->unique();
            $table->string('category', 100)->index();
            $table->string('brand', 100)->index();
            $table->string('name', 100)->index();
            $table->integer('list-price')->index();
            
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
