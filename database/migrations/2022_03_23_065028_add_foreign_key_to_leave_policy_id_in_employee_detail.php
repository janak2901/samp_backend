<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToLeavePolicyIdInEmployeeDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('employee_details')) {
            Schema::table('employee_details', function (Blueprint $table) {
                if (Schema::hasColumn('employee_details', 'leave_policy')) {
                    $keyExists = DB::select(DB::raw('SHOW KEYS FROM employee_details WHERE Key_name="employee_details_leave_policy_foreign"'));
                    if (empty($keyExists)) {
                        // $table->foreign("leave_policy")->references('id')->on("leave_policies")->onUpdate('cascade')->onDelete('cascade');
                    }
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
        // if (Schema::hasTable('employee_details')) {
        //     Schema::table('employee_details', function (Blueprint $table) {
        //         if (Schema::hasColumn('employee_details', 'leave_policy')) {
        //             $table->dropForeign(['leave_policy']);
        //             $table->unsignedBigInteger('leave_policy');
        //             $table->foreign("leave_policy")->references('id')->on('leave_policies')->onUpdate('cascade')->onDelete('cascade');
        //         }
        //     });
        // }
    }
}
