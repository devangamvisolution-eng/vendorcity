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
        Schema::table('ci_orders', function (Blueprint $table) {
            $table->string('subscription_status', 50)->nullable()->comment('Pending, Active, Paused, Renewal Upcoming, Payment Failed, Grace Period, Ending, Cancelled, Completed, Suspended');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ci_orders', function (Blueprint $table) {
            $table->dropColumn('subscription_status');
        });
    }
};
