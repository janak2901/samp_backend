<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateOvertimePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('overtime_policies')) {
            Schema::table(
                'overtime_policies',
                function (Blueprint $table) {
                    if (Schema::hasColumn('overtime_policies', 'overtime_payout')) {
                        DB::statement("ALTER TABLE `overtime_policies` CHANGE `overtime_payout` `overtime_payout` ENUM('none','1x','1.5x','2x','custom') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;");
                    }

                    if (!Schema::hasColumn('overtime_policies', 'payout_value')) {
                        $table->string('payout_value')->nullable()->after('overtime_payout');
                    }

                    if (!Schema::hasColumn('overtime_policies', 'note')) {
                        $table->string('note')->nullable()->after('payout_value');
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
        if (Schema::hasTable('overtime_policies')) {
            Schema::table(
                'overtime_policies',
                function (Blueprint $table) {
                    if (Schema::hasColumn('overtime_policies', 'payout_value')) {
                        $table->dropColumn('payout_value');
                    }

                    if (Schema::hasColumn('overtime_policies', 'note')) {
                        $table->dropColumn('note');
                    }
                }
            );
        }
    }
}