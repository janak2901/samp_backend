<?php

use Centroall\Helper\Utils\CommonUtil;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusAndRemoveDescriptionInHolidayCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "Migrating in database --> " . DB::connection()->getDatabaseName() . ' at ' . date('Y-m-d h:i A'));
        CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "Migration name --> 2022_01_24_110011_add_status_and_remove_description_in_holiday_categories_table");

        if (Schema::hasTable('holiday_categories')) {
            Schema::table('holiday_categories', function (Blueprint $table) {
                if (!Schema::hasColumn('holiday_categories', 'status')) {
                    $table->boolean('status')->after('category')->default(0);

                    CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "status field added in holiday_categories table successfully. --> " . DB::connection()->getDatabaseName() . ' at ' . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "2022_01_24_110011_add_status_and_remove_description_in_holiday_categories_table --> status column already exists in holiday_categories table." . date('Y-m-d h:i A'));
                }
                if (Schema::hasColumn('holiday_categories', 'description')) {
                    $table->dropColumn('description');

                    CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "status field added in holiday_categories table. --> " . DB::connection()->getDatabaseName() . ' at ' . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "2022_01_24_110011_add_status_and_remove_description_in_holiday_categories_table --> description column not found in holiday_categories table." . date('Y-m-d h:i A'));
                }
            });
        } else {
            CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "2022_01_24_110011_add_status_and_remove_description_in_holiday_categories_table --> Holiday categories table not found." . date('Y-m-d h:i A'));
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
        CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "Migration name --> 2022_01_24_110011_add_status_and_remove_description_in_holiday_categories_table");

        if (Schema::hasTable('holiday_categories')) {
            Schema::table('holiday_categories', function (Blueprint $table) {
                if (!Schema::hasColumn('holiday_categories', 'description')) {
                    $table->text('description')->after('category')->nullable();

                    CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "2022_01_24_110011_add_status_and_remove_description_in_holiday_categories_table --> description field added in holiday_categories table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "2022_01_24_110011_add_status_and_remove_description_in_holiday_categories_table --> description field does not exists in holiday_categories table." . date('Y-m-d h:i A'));
                }
                if (Schema::hasColumn('holiday_categories', 'status')) {
                    $table->dropColumn('status');

                    CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "2022_01_24_110011_add_status_and_remove_description_in_holiday_categories_table --> status field removed from holiday_categories table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "2022_01_24_110011_add_status_and_remove_description_in_holiday_categories_table --> description field does not exists in users table." . date('Y-m-d h:i A'));
                }
            });
        } else {
            CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "2022_01_24_110011_add_status_and_remove_description_in_holiday_categories_table --> Holiday categories table not found." . date('Y-m-d h:i A'));
        }
    }
}
