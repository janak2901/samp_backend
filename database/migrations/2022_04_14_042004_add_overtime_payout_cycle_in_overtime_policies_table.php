<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOvertimePayoutCycleInOvertimePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('overtime_policies')) {
            Schema::table('overtime_policies', function (Blueprint $table) {
                if (!Schema::hasColumn('overtime_policies', 'overtime_payout_cycle')) {
                    $table->enum('overtime_payout_cycle', ['monthly', 'quarterly', 'half_yearly'])->nullable()->after('name');
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
        if (Schema::hasTable('overtime_policies')) {
            Schema::table('overtime_policies', function (Blueprint $table) {
                if (Schema::hasColumn('overtime_policies', 'overtime_payout_cycle')) {
                    $table->dropColumn('overtime_payout_cycle');
                }
            });
        }
    }
}