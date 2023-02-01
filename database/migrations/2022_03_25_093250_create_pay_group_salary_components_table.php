<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayGroupSalaryComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('pay_group_salary_components')) {
            Schema::create('pay_group_salary_components', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('pay_group');
                $table->foreign("pay_group")->references('id')->on("pay_groups")->onUpdate('cascade')->onDelete('cascade');
                $table->unsignedBigInteger('salary_component');
                $table->foreign("salary_component")->references('id')->on("salary_components")->onUpdate('cascade')->onDelete('cascade');
                $table->enum('calculation_type', ['percentage', 'fixed_amount', 'auto_calculated'])->nullable();
                $table->double('calculation_value', 8, 4)->nullable();
                $table->string('based_on_earning')->nullable();
                $table->boolean('can_remove')->default(1);
                // $table->float('monthly')->default(0);
                // $table->float('annually')->default(0);
                // $table->float('gross_monthly')->default(0);
                // $table->float('gross_annually')->default(0);
                // $table->float('net_monthly')->default(0);
                // $table->float('net_annually')->default(0);
                // $table->float('ctc_monthly')->default(0);
                // $table->float('ctc_annually')->default(0);
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
        Schema::dropIfExists('pay_group_salary_components');
    }
}