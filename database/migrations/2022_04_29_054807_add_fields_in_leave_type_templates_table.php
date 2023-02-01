<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsInLeaveTypeTemplatesTable extends Migration
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
                if (!Schema::hasColumn('leave_type_templates', 'encashment_month')) {
                    $table->string('encashment_month')->nullable()->after('encashment_type');
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
                if (Schema::hasColumn('leave_type_templates', 'encashment_month')) {
                    $table->dropColumn('encashment_month');
                }
            });
        }
    }
}