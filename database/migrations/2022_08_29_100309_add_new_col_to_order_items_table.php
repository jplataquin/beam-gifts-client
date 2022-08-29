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
            $table->char('status',4)->nullaable()->after('uid');
            $table->bigInteger('user_id')->nullable()->after('description');
            $table->integer('consumed')->default(0)->after('quantity');
            $table->json('logs')->default('{}')->after('claimed_at');
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
            $table->dropColumn('status');
            $table->dropColumn('user_id');
            $table->dropColumn('consumed');
            $table->dropColumn('logs');
        });
    }
};
