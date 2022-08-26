<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->char('uid',64);
            $table->bigInteger('brand_id');
            $table->bigInteger('item_id');
            $table->integer('quantity');
            $table->string('brand_name');
            $table->string('item_name');
            $table->char('type',4);
            $table->char('category',4);
            $table->decimal('price',10,2);
            $table->integer('expiry');
            $table->longText('description');
            $table->boolean('extended')->default(false);
            $table->dateTime('expires_at')->nullable();
            $table->dateTime('claimed_at')->nullable();
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
        Schema::dropIfExists('order_items');
    }
};
