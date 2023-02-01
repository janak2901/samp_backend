<?php

use Centroall\Helper\Utils\CommonUtil;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHolidayCategoryIdInHolidayListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "Migrating in database --> " . DB::connection()->getDatabaseName() . ' at ' . date('Y-m-d h:i A'));
        CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "Migration name --> 2022_01_24_111200_add_holiday_category_id_in_holiday_lists_table");

        if (Schema::hasTable('holiday_lists')) {
            Schema::table('holiday_lists', function (Blueprint $table) {
                if (!Schema::hasColumn('holiday_lists', 'holiday_category_id')) {
                    $table->unsignedBigInteger('holiday_category_id')->after('name')->nullable();
                    $table->foreign("holiday_category_id")->references('id')->on("holiday_categories")->onUpdate('cascade')->onDelete('cascade');

                    CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "holiday_category_id field added in holiday_categories table successfully. --> " . DB::connection()->getDatabaseName() . ' at ' . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "2022_01_24_111200_add_holiday_category_id_in_holiday_lists_table --> holiday_category_id column already exists in holiday_categories table." . date('Y-m-d h:i A'));
                }
            });
        } else {
            CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "2022_01_24_111200_add_holiday_category_id_in_holiday_lists_table --> Holiday lists table not found." . date('Y-m-d h:i A'));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "Migrating in database --> " . DB::connection()->getDatabaseName() . ' at ' . date('Y-m-d h:i A'));
        CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "Migration name --> 2022_01_24_111200_add_holiday_category_id_in_holiday_lists_table");

        if (Schema::hasTable('holiday_lists')) {
            Schema::table('holiday_lists', function (Blueprint $table) {
                if (Schema::hasColumn('holiday_lists', 'holiday_category_id')) {
                    $table->dropForeign(['holiday_category_id']);
                    $table->dropColumn("holiday_category_id");

                    CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "2022_01_24_111200_add_holiday_category_id_in_holiday_lists_table --> holiday_category_id field removed from holiday_lists table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "2022_01_24_111200_add_holiday_category_id_in_holiday_lists_table --> holiday_category_id field does not exists in holiday_lists table." . date('Y-m-d h:i A'));
                }
            });
        } else {
            CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "2022_01_24_111200_add_holiday_category_id_in_holiday_lists_table --> Holiday lists table not found." . date('Y-m-d h:i A'));
        }
    }
}
