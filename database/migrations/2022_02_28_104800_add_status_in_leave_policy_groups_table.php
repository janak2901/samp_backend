<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusInLeavePolicyGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('leave_policy_groups')) {
            Schema::table('leave_policy_groups', function (Blueprint $table) {
                if (!Schema::hasColumn('leave_policy_groups', 'status')) {
                    $table->boolean('status')->default(0)->after('quota');
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
        if (Schema::hasTable('leave_policy_groups')) {
            Schema::table('leave_policy_groups', function (Blueprint $table) {
                if (Schema::hasColumn('leave_policy_groups', 'status')) {
                    $table->dropColumn('status');
                }
            });
        }
    }
}