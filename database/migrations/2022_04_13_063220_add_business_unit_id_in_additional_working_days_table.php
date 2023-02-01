<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBusinessUnitIdInAdditionalWorkingDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('additional_working_days')) {
            if (!Schema::hasColumn('additional_working_days', 'business_unit_id')) {
                Schema::table('additional_working_days', function (Blueprint $table) {
                    $table->unsignedBigInteger('business_unit_id')->nullable()->after('id');
                    $table->foreign("business_unit_id")->references('id')->on("business_units")->onUpdate('cascade')->onDelete('cascade');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('additional_working_days', function (Blueprint $table) {
            if (Schema::hasColumn('additional_working_days', 'business_unit_id')) {
                $table->dropForeign(['business_unit_id']);
                $table->dropColumn('business_unit_id');
            }
        });
    }
}