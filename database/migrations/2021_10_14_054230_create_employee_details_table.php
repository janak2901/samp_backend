<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!(Schema::hasTable('employee_details'))) {
            Schema::create('employee_details', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger("user_id");
                $table->string("emp_id", 15)->nullable();
                $table->string("secondary_job_title")->nullable();
                $table->unsignedBigInteger("series_id")->nullable();
                $table->unsignedBigInteger("business_unit_id")->nullable();
                $table->unsignedBigInteger("location_id")->nullable();
                $table->unsignedBigInteger("department_id")->nullable();
                $table->unsignedBigInteger('job_title_id')->nullable();
                $table->foreign("job_title_id")->references('id')->on("designations")->onUpdate('cascade')->onDelete('cascade');
                $table->unsignedBigInteger("leader_id")->nullable();
                $table->unsignedBigInteger("work_type_id")->nullable();
                $table->unsignedBigInteger("probation_policy_id")->nullable();
                $table->unsignedBigInteger("notice_period_id")->nullable();
                $table->unsignedBigInteger("tracker_productivity_id")->nullable();
                $table->unsignedBigInteger("report_to")->nullable();
                $table->foreignId("leave_plan_id")->nullable();
                $table->foreignId("shif_id")->nullable();
                $table->unsignedBigInteger("week_off_id")->nullable();
                $table->unsignedBigInteger("holiday_list_id")->nullable();
                $table->unsignedBigInteger("overtime_policy_id")->nullable();
                $table->unsignedBigInteger("leave_deduction_policy_id")->nullable();
                $table->unsignedBigInteger("employee_policy_to")->nullable();
                $table->foreignId("permission_id")->nullable();
                $table->foreign("probation_policy_id")->references('id')->on("probation_policies")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("notice_period_id")->references('id')->on("notice_period_policies")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("tracker_productivity_id")->references('id')->on("tracker_policies")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("report_to")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("week_off_id")->references('id')->on("week_offs")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("holiday_list_id")->references('id')->on("holiday_lists")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("overtime_policy_id")->references('id')->on("overtime_policies")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("leave_deduction_policy_id")->references('id')->on("leave_deduct_policies")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("employee_policy_to")->references('id')->on("employeement_policies")->onUpdate('cascade')->onDelete('cascade');
                $table->integer("salary")->nullable();
                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();
                $table->foreign("created_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("updated_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("deleted_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("user_id")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("series_id")->references('id')->on("series")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("business_unit_id")->references('id')->on("business_units")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("location_id")->references('id')->on("locations")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("department_id")->references('id')->on("departments")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("leader_id")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("work_type_id")->references('id')->on("work_types")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("shif_id")->references('id')->on("shifts")->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('employee_details');
    }
}
