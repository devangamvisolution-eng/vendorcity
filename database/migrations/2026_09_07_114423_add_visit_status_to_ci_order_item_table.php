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
        Schema::table('ci_order_item', function (Blueprint $table) {
            $table->string('visit_status', 50)->nullable()->comment('Scheduled, Assigned, On the Way, In Progress, Completed, Rescheduled, Skipped, Cancelled, No-show, Vendor Cancelled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ci_order_item', function (Blueprint $table) {
            $table->dropColumn('visit_status');
        });
    }
};
