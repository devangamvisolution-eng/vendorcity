<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTabbyFieldsToCiOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ci_orders', function (Blueprint $table) {
            $table->string('payment_provider')->nullable()->after('payment_status');
            $table->string('transaction_id')->nullable()->after('payment_provider');
            $table->string('tabby_payment_id')->nullable()->after('transaction_id');
            $table->text('payment_response')->nullable()->after('tabby_payment_id');
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
            $table->dropColumn([
                'payment_provider',
                'transaction_id',
                'tabby_payment_id',
                'payment_response',
            ]);
        });
    }
}
