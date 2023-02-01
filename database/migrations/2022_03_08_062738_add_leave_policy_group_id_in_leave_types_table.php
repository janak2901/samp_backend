<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLeavePolicyGroupIdInLeaveTypesTable extends Migration
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
                if (!Schema::hasColumn('leave_types', 'leave_policy_group')) {
                    $table->unsignedBigInteger('leave_policy_group')->nullable()->after('status');
                    $table->foreign("leave_policy_group")->references('id')->on("leave_policy_groups")->onUpdate('cascade')->onDelete('cascade');
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
                if (Schema::hasColumn('leave_types', 'leave_policy_group')) {
                    $table->dropForeign(['leave_policy_group']);
                    $table->dropColumn('leave_policy_group');
                }
            });
        }
    }
}