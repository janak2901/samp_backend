<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsInPayslipsTable extends Migration
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
                if (!Schema::hasColumn('payslips', 'actual_working_days')) {
                    $table->bigInteger('actual_working_days')->default(0)->after('for_month_year');
                }
                if (!Schema::hasColumn('payslips', 'total_leaves')) {
                    $table->bigInteger('total_leaves')->default(0)->after('actual_working_days');
                }
                if (!Schema::hasColumn('payslips', 'days_payable')) {
                    $table->bigInteger('days_payable')->default(0)->after('total_leaves');
                }
                if (!Schema::hasColumn('payslips', 'gross_days_payable')) {
                    $table->bigInteger('gross_days_payable')->default(0)->after('days_payable');
                }
                if (!Schema::hasColumn('payslips', 'ctc')) {
                    $table->bigInteger('ctc')->default(0)->after('gross_days_payable');
                }
                if (!Schema::hasColumn('payslips', 'payable_ctc')) {
                    $table->bigInteger('payable_ctc')->default(0)->after('ctc');
                }
                if (!Schema::hasColumn('payslips', 'net_payable_amount')) {
                    $table->bigInteger('net_payable_amount')->default(0)->after('payable_ctc');
                }
                if (!Schema::hasColumn('payslips', 'earning_salary_component_json')) {
                    $table->json('earning_salary_component_json')->nullable()->after('net_payable_amount');
                }
                if (!Schema::hasColumn('payslips', 'deduction_salary_component_json')) {
                    $table->json('deduction_salary_component_json')->nullable()->after('earning_salary_component_json');
                }
                if (!Schema::hasColumn('payslips', 'quarterly_leave_encashed')) {
                    $table->boolean('quarterly_leave_encashed')->default(0)->after('deduction_salary_component_json');
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
        Schema::table('payslips', function (Blueprint $table) {
            if (Schema::hasColumn('payslips', 'actual_working_days')) {
                $table->dropColumn('actual_working_days');
            }
            if (Schema::hasColumn('payslips', 'total_leaves')) {
                $table->dropColumn('total_leaves');
            }
            if (Schema::hasColumn('payslips', 'days_payable')) {
                $table->dropColumn('days_payable');
            }
            if (Schema::hasColumn('payslips', 'gross_days_payable')) {
                $table->dropColumn('gross_days_payable');
            }
            if (Schema::hasColumn('payslips', 'ctc')) {
                $table->dropColumn('ctc');
            }
            if (Schema::hasColumn('payslips', 'payable_ctc')) {
                $table->dropColumn('payable_ctc');
            }
            if (Schema::hasColumn('payslips', 'net_payable_amount')) {
                $table->dropColumn('net_payable_amount');
            }
            if (Schema::hasColumn('payslips', 'earning_salary_component_json')) {
                $table->dropColumn('earning_salary_component_json');
            }
            if (Schema::hasColumn('payslips', 'deduction_salary_component_json')) {
                $table->dropColumn('deduction_salary_component_json');
            }
        });
    }
}