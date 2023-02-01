<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDataTypeOfSomeFieldsInLeaveTypesTable extends Migration
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
                if (Schema::hasColumn('leave_types', 'carry_forward')) {
                    $table->float('carry_forward')->nullable()->change();
                }
                if (Schema::hasColumn('leave_types', 'encashment')) {
                    $table->float('encashment')->nullable()->change();
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
                if (Schema::hasColumn('leave_types', 'carry_forward')) {
                    $table->smallInteger('carry_forward')->nullable()->change();
                }
                if (Schema::hasColumn('leave_types', 'encashment')) {
                    $table->smallInteger('encashment')->nullable()->change();
                }
            });
        }
    }
}