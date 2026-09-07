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
            if (!Schema::hasColumn('ci_order_item', 'is_renewed')) {
                $table->boolean('is_renewed')->default(0)->after('end_date');
            }
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
            $table->dropColumn('is_renewed');
        });
    }
};
