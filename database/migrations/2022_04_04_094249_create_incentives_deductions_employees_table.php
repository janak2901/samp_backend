<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncentivesDeductionsEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('incentives_deductions_employees')) {
            Schema::create('incentives_deductions_employees', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('incentive_deduction_id');
                $table->foreign("incentive_deduction_id")->references('id')->on("incentives_deductions")->onUpdate('cascade')->onDelete('cascade');
                $table->unsignedBigInteger('user_id');
                $table->foreign("user_id")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->enum('status', ['pending', 'paid'])->default('pending');
                $table->unsignedBigInteger('paid_by')->nullable();
                $table->foreign("paid_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->bigInteger('amount');
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
        Schema::dropIfExists('incentives_deductions_employees');
    }
}