<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPayGroupIdInEmployeeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('employee_details')) {
            Schema::table('employee_details', function (Blueprint $table) {
                if (!Schema::hasColumn('employee_details', 'pay_group')) {
                    $table->unsignedBigInteger('pay_group')->nullable()->after('secondary_job_title');
                    $table->foreign("pay_group")->references('id')->on("pay_groups")->onUpdate('cascade')->onDelete('cascade');
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
        if (Schema::hasTable('employee_details')) {
            Schema::table('employee_details', function (Blueprint $table) {
                if (Schema::hasColumn('employee_details', 'pay_group')) {
                    $table->dropForeign(['pay_group']);
                    $table->dropColumn('pay_group');
                }
            });
        }
    }
}