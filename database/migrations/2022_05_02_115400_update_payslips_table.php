<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePayslipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('payslips')) {
            Schema::table('payslips', function (Blueprint $table) {
                if (Schema::hasColumn('payslips', 'earning_salary_component_json')) {
                    $table->text('earning_salary_component_json')->nullable()->change();
                }

                if (Schema::hasColumn('payslips', 'deduction_salary_component_json')) {
                    $table->text('deduction_salary_component_json')->nullable()->change();
                }
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
        if (Schema::hasTable('payslips')) {
            Schema::table('payslips', function (Blueprint $table) {
                if (Schema::hasColumn('payslips', 'earning_salary_component_json')) {
                    $table->json('earning_salary_component_json')->nullable()->change();
                }

                if (Schema::hasColumn('payslips', 'deduction_salary_component_json')) {
                    $table->json('deduction_salary_component_json')->nullable()->change();
                }
            });
        }
    }
}