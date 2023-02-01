<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!(Schema::hasTable('employee_policies'))) {

            Schema::create('employee_policies', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger("user_id");
                $table->unsignedBigInteger("probation_policy_id");
                $table->unsignedBigInteger("notice_period_id");
                $table->unsignedBigInteger("tracker_productivity_id");
                $table->unsignedBigInteger("leave_policy_id");
                $table->unsignedBigInteger("shift_id");
                $table->unsignedBigInteger("week_off_id");
                $table->unsignedBigInteger("holiday_id");
                $table->unsignedBigInteger("overtime_policy_id");
                $table->unsignedBigInteger("leave_deduction_policy_id");
                $table->unsignedBigInteger("none_technical_policy_id");
                $table->unsignedBigInteger("employeement_policy_id");
                $table->unsignedBigInteger('created_by');
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();
                $table->foreign("created_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("updated_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("deleted_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                // $table->foreign("user_id")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                // $table->foreign("probation_policy_id")->references('id')->on("probation_policies")->onUpdate('cascade')->onDelete('cascade');
                // $table->foreign("notice_period_id")->references('id')->on("notice_periods")->onUpdate('cascade')->onDelete('cascade');
                // $table->foreign("tracker_productivity_id")->references('id')->on("tracker_productivities")->onUpdate('cascade')->onDelete('cascade');
                // $table->foreign("leave_policy_id")->references('id')->on("leave_policies")->onUpdate('cascade')->onDelete('cascade');
                // $table->foreign("shift_id")->references('id')->on("shifts")->onUpdate('cascade')->onDelete('cascade');
                // $table->foreign("week_off_id")->references('id')->on("week_offs")->onUpdate('cascade')->onDelete('cascade');
                // $table->foreign("holiday_id")->references('id')->on("holidays")->onUpdate('cascade')->onDelete('cascade');
                // $table->foreign("overtime_policy_id")->references('id')->on("overtime_policies")->onUpdate('cascade')->onDelete('cascade');
                // $table->foreign("leave_deduction_policy_id")->references('id')->on("leave_deduction_policies")->onUpdate('cascade')->onDelete('cascade');
                // $table->foreign("none_technical_policy_id")->references('id')->on("none_technical_policies")->onUpdate('cascade')->onDelete('cascade');
                // $table->foreign("employeement_policy_id")->references('id')->on("employeement_policies")->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('employee_policy');
    }
}
