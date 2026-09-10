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
        if (!Schema::hasTable('ci_audit_logs')) {
            Schema::create('ci_audit_logs', function (Blueprint $table) {
                $table->id();
                $table->integer('order_id')->index();
                $table->integer('user_id')->nullable()->index();
                $table->integer('admin_id')->nullable()->index();

                $table->string('action_type', 100);
                $table->text('description');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ci_audit_logs');
    }
};
