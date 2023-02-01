<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!(Schema::hasTable('employee_salaries'))) {
            Schema::create('employee_salaries', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger("user_id");
                $table->integer("month");
                $table->integer("year");
                $table->integer("basic_salary");
                $table->integer("month_days");
                $table->integer("working_days");
                $table->integer("present_days");
                $table->integer("leaves");
                $table->integer("holiday");
                $table->integer("paid_leaves");
                $table->integer("pf_tax");
                $table->integer("pt_tax");
                $table->integer("esi_tax");
                $table->integer("leave_deduction");
                $table->integer("time_deduction");
                $table->integer("weekoff_deduction_days");
                $table->integer("weekoff_deduction");
                $table->integer("other_deduction");
                $table->integer("insentive");
                $table->integer("earned_salary");
                $table->integer("ot_hours");
                $table->integer("total_overtime");
                $table->integer("total_earned");
                $table->string("insentive_detail", 30);
                $table->integer("total_earning");
                $table->integer("total_deduction");
                $table->integer("payable_amount");
                $table->json("datewise_info");
                $table->boolean("status");
                $table->integer("basic_gross");
                $table->integer("basic_allowance");
                $table->integer("e_esi_tax");
                $table->integer("epf_tax");
                $table->integer("loss_days");
                $table->integer("bonus");
                $table->integer("bonus_detail");
                $table->integer("payable_days");
                $table->integer("is_abry");
                $table->unsignedBigInteger('created_by');
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();
                $table->foreign("created_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("updated_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("deleted_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("user_id")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('employee_salary');
    }
}
