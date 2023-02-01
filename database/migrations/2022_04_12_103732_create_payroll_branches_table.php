<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payroll_branches')) {
            Schema::create('payroll_branches', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('business_unit_id');
                $table->foreign("business_unit_id")->references('id')->on("business_units")->onUpdate('cascade')->onDelete('cascade');
                $table->unsignedBigInteger('payroll_step_id');
                $table->foreign("payroll_step_id")->references('id')->on("payroll_steps")->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('payroll_branches');
    }
}