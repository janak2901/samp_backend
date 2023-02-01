<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAllProjMemberNotifyFieldInLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('employee_leave_managements')) {
            Schema::table('employee_leave_managements', function (Blueprint $table) {
                if (!Schema::hasColumn('employee_leave_managements', 'all_proj_member_notify')) {
                    $table->boolean('all_proj_members_notify')->default(0)->after('note');
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
        if (Schema::hasTable('employee_leave_managements')) {
            Schema::table('employee_leave_managements', function (Blueprint $table) {
                if (Schema::hasColumn('employee_leave_managements', 'all_proj_member_notify')) {
                    $table->dropColumn('all_proj_members_notify');
                }
            });
        }
    }
}