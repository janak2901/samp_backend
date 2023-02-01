<?php

use Centroall\Helper\Utils\CommonUtil;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReplaceHolidayListIdToHolidayGroupIdInEmployeeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "Migrating in database --> " . DB::connection()->getDatabaseName() . ' at ' . date('Y-m-d h:i A'));
        CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "Migration name --> 2022_01_25_054611_replace_holiday_list_id_to_holiday_group_id_in_employee_details_table");

        if (Schema::hasTable('employee_details')) {
            Schema::table('employee_details', function (Blueprint $table) {
                if (Schema::hasColumn('employee_details', 'holiday_list_id')) {
                    $table->dropForeign(['holiday_list_id']);
                    $table->dropColumn("holiday_list_id");

                    CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "2022_01_25_054611_replace_holiday_list_id_to_holiday_group_id_in_employee_details_table --> holiday_list_id field removed from employee_details table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "2022_01_25_054611_replace_holiday_list_id_to_holiday_group_id_in_employee_details_table --> holiday_list_id field does not exists in employee_details table." . date('Y-m-d h:i A'));
                }

                if (!Schema::hasColumn('employee_details', 'holiday_category_id')) {
                    $table->unsignedBigInteger('holiday_category_id')->after('week_off_id')->nullable();
                    $table->foreign("holiday_category_id")->references('id')->on("holiday_categories")->onUpdate('cascade')->onDelete('cascade');

                    CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "holiday_category_id field added in employee_details table successfully. --> " . DB::connection()->getDatabaseName() . ' at ' . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "2022_01_25_054611_replace_holiday_list_id_to_holiday_group_id_in_employee_details_table --> holiday_category_id field exists in employee_details table." . date('Y-m-d h:i A'));
                }
            });
        } else {
            CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "2022_01_25_054611_replace_holiday_list_id_to_holiday_group_id_in_employee_details_table --> Employee details table not found." . date('Y-m-d h:i A'));
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
        CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "Migration name --> 2022_01_25_054611_replace_holiday_list_id_to_holiday_group_id_in_employee_details_table");

        if (Schema::hasTable('employee_details')) {
            Schema::table('employee_details', function (Blueprint $table) {
                if (Schema::hasColumn('employee_details', 'holiday_category_id')) {
                    $table->dropForeign(['holiday_category_id']);
                    $table->dropColumn("holiday_category_id");

                    CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "2022_01_25_054611_replace_holiday_list_id_to_holiday_group_id_in_employee_details_table --> holiday_category_id field removed from employee_details table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "2022_01_25_054611_replace_holiday_list_id_to_holiday_group_id_in_employee_details_table --> holiday_category_id field does not exists in employee_details table." . date('Y-m-d h:i A'));
                }

                if (!Schema::hasColumn('employee_details', 'holiday_list_id')) {
                    $table->unsignedBigInteger('holiday_list_id')->after('week_off_id')->nullable();
                    $table->foreign("holiday_list_id")->references('id')->on("holiday_lists")->onUpdate('cascade')->onDelete('cascade');

                    CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "holiday_list_id field added in employee_details table successfully. --> " . DB::connection()->getDatabaseName() . ' at ' . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "2022_01_25_054611_replace_holiday_list_id_to_holiday_group_id_in_employee_details_table --> holiday_list_id field exists in employee_details table." . date('Y-m-d h:i A'));
                }
            });
        } else {
            CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "2022_01_25_054611_replace_holiday_list_id_to_holiday_group_id_in_employee_details_table --> Employee details table not found." . date('Y-m-d h:i A'));
        }
    }
}
