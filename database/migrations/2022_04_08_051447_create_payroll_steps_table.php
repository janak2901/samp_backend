<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_steps')) {
            Schema::create('payroll_steps', function (Blueprint $table) {
                $table->id();
                $table->string('for_month_year');
                //$table->boolean('company_details')->default(0);
                //$table->boolean('statutory_components')->default(0);
                $table->boolean('pay_group')->default(1);
                $table->boolean('additional_working_days')->default(1);
                $table->boolean('leaves')->default(0);
                $table->boolean('overtime_manual_time')->default(0);
                //$table->boolean('attendance')->default(1);
                $table->boolean('incentives_deductions')->default(0);
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
        Schema::dropIfExists('payroll_steps');
    }
}