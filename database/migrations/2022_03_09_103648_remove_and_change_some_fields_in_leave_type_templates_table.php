<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveAndChangeSomeFieldsInLeaveTypeTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('leave_type_templates')) {
            Schema::table('leave_type_templates', function (Blueprint $table) {
                if (Schema::hasColumn('leave_type_templates', 'accrual')) {
                    $table->dropColumn('accrual');
                }

                if (Schema::hasColumn('leave_type_templates', 'reset')) {
                    $table->dropColumn('reset');
                }

                if (!Schema::hasColumn('leave_type_templates', 'reset_type')) {
                    $table->enum('reset_type', ['yearly', 'quarterly', 'half_year'])->nullable()->after('encashment_max_limit');
                }

                if (!Schema::hasColumn('leave_type_templates', 'reset_on')) {
                    $table->string('reset_on', 50)->nullable()->after('reset_type');
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
        if (Schema::hasTable('leave_type_templates')) {
            Schema::table('leave_type_templates', function (Blueprint $table) {
                if (!Schema::hasColumn('leave_type_templates', 'accrual')) {
                    $table->text('accrual')->nullable()->after('encashment_max_limit');
                }

                if (!Schema::hasColumn('leave_type_templates', 'reset')) {
                    $table->text('reset')->nullable()->after('accrual');
                }

                if (Schema::hasColumn('leave_type_templates', 'reset_type')) {
                    $table->dropColumn('reset_type');
                }

                if (Schema::hasColumn('leave_type_templates', 'reset_on')) {
                    $table->dropColumn('reset_on');
                }
            });
        }
    }
}