<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLeavePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('leave_policies')) {
            Schema::table('leave_policies', function (Blueprint $table) {
                if (!Schema::hasColumn('leave_policies', 'yearly_reset_on')) {
                    $table->string('yearly_reset_on', 50)->nullable()->after('effective_after');
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
        if (Schema::hasTable('leave_policies')) {
            Schema::table('leave_policies', function (Blueprint $table) {
                if (!Schema::hasColumn('leave_policies', 'yearly_reset_on')) {
                    $table->dropColumn('yearly_reset_on');
                }
            });
        }
    }
}