<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLeaveTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('leave_types')) {
            Schema::table('leave_types', function (Blueprint $table) {
                if (Schema::hasColumn('leave_types', 'salary_deduction_days')) {
                    $table->dropColumn('salary_deduction_days');
                }
                if (Schema::hasColumn('leave_types', 'reset_type')) {
                    $table->dropColumn('reset_type');
                }
                if (Schema::hasColumn('leave_types', 'reset_on')) {
                    $table->dropColumn('reset_on');
                }
                if (Schema::hasColumn('leave_type_templates', 'allow_if_join_before')) {
                    $table->dropColumn('allow_if_join_before');
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
        if (Schema::hasTable('leave_types')) {
            Schema::table('leave_types', function (Blueprint $table) {
                if (!Schema::hasColumn('leave_types', 'salary_deduction_days')) {
                    $table->smallInteger('salary_deduction_days')->nullable()->after('effective_after_from');
                }
                if (!Schema::hasColumn('leave_types', 'reset_type')) {
                    $table->enum('reset_type', ['yearly', 'quarterly', 'half_year'])->nullable()->after('encashment_max_limit');
                }
                if (!Schema::hasColumn('leave_types', 'reset_on')) {
                    $table->string('reset_on', 50)->nullable()->after('reset_type');
                }
                if (!Schema::hasColumn('leave_type_templates', 'allow_if_join_before')) {
                    $table->tinyInteger('allow_if_join_before')->nullable()->after('encashment_max_limit');
                }
            });
        }
    }
}