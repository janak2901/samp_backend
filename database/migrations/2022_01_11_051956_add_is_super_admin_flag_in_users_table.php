<?php

use Centroall\Helper\Utils\CommonUtil;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddIsSuperAdminFlagInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "Migrating in database --> " . DB::connection()->getDatabaseName() . ' at ' . date('Y-m-d h:i A'));
        CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "Migration name --> 2022_01_11_051956_add_is_super_admin_flag_in_users_table");

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'is_super_admin')) {
                    $table->boolean('is_super_admin')->default(0)->after('id');

                    CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "Migrated successfully. --> " . DB::connection()->getDatabaseName() . ' at ' . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "2022_01_11_051956_add_is_super_admin_flag_in_users_table --> is_super_admin column already exists in users table." . date('Y-m-d h:i A'));
                }
            });
        } else {
            CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "2022_01_11_051956_add_is_super_admin_flag_in_users_table --> Users table not found." . date('Y-m-d h:i A'));
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
        CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "Migration name --> 2022_01_11_051956_add_is_super_admin_flag_in_users_table");

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'is_super_admin')) {
                    $table->dropColumn('is_super_admin');

                    CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "2022_01_11_051956_add_is_super_admin_flag_in_users_table --> is_super_admin field removed from users table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "2022_01_11_051956_add_is_super_admin_flag_in_users_table --> is_super_admin field does not exists in users table." . date('Y-m-d h:i A'));
                }
            });
        } else {
            CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "2022_01_11_051956_add_is_super_admin_flag_in_users_table --> Users table not found." . date('Y-m-d h:i A'));
        }
    }
}
