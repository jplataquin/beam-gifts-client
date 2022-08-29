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
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('claimed_at');
            $table->dropColumn('expires_at');
            $table->dateTime('paid_at')->nullable()->after('extended');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dateTime('claimed_at')->nullable()->after('extended');
            $table->dateTime('expires_at')->nullable()->after('extended');
        });
    }
};
