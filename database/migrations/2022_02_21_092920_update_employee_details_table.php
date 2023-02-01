<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEmployeeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('employee_details')) {
            Schema::table(
                'employee_details',
                function (Blueprint $table) {
                    if (Schema::hasColumn('employee_details', 'leave_deduction_policy_id')) {
                        $table->dropForeign(['leave_deduction_policy_id']);
                        $table->renameColumn('leave_deduction_policy_id', 'leave_policy');
                        $table->foreign("leave_policy")->references('id')->on('leave_policies')->onUpdate('cascade')->onDelete('cascade');
                    }
                }
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
