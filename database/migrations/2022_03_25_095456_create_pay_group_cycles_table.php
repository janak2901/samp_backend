<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayGroupCyclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('pay_group_cycles')) {
            Schema::create('pay_group_cycles', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('pay_group');
                $table->foreign("pay_group")->references('id')->on("pay_groups")->onUpdate('cascade')->onDelete('cascade');
                $table->enum('payout_based_on', ['total_month_days', 'actual_working_days']);
                $table->enum('pay_emp_on', ['month_last_day', 'specific_day']);
                $table->smallInteger('pay_emp_on_day')->nullable();
                $table->boolean('show_cycle_in_pay_slip')->default(0);
                $table->boolean('exclude_holidays')->default(0);
                $table->unsignedBigInteger('created_by');
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();
                $table->foreign("created_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("updated_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("deleted_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->timestamps();
                $table->softDeletes();
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
        Schema::dropIfExists('pay_group_cycles');
    }
}