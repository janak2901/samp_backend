<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRemainingFieldsInLeavePolicyGroupsTable extends Migration
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
                if (!Schema::hasColumn('leave_policy_groups', 'quota_time')) {
                    $table->enum('quota_time', ["year", "month", "half_year", "quarter"])->after("leave_type");
                }

                if (!Schema::hasColumn('leave_policy_groups', 'quota_day')) {
                    $table->enum('quota_day', ["1st", "2nd", "3rd", "last_day"])->after("quota_time");
                }

                if (!Schema::hasColumn('leave_policy_groups', 'quota')) {
                    $table->integer('quota')->after("quota_day");
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
                if (Schema::hasColumn('leave_policy_groups', 'quota_time')) {
                    $table->dropColumn('quota_time');
                }

                if (Schema::hasColumn('leave_policy_groups', 'quota_day')) {
                    $table->dropColumn('quota_time');
                }

                if (Schema::hasColumn('leave_policy_groups', 'quota')) {
                    $table->dropColumn('quota');
                }
            });
        }
    }
}