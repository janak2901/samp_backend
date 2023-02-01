<?php

use Centroall\Helper\Utils\CommonUtil;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateActiveUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $databaseName = DB::connection()->getDatabaseName();
        CommonUtil::logRecorder('migration-log', 'active_users', 'migrating in - ' . $databaseName);

        if (Schema::hasTable('active_users')) {
            DB::table('active_users')->truncate();
            Schema::table('active_users', function (Blueprint $table) {
                if (!Schema::hasColumn('active_users', 'device_type')) {
                    CommonUtil::logRecorder('migration-log', 'active_users', 'Changes applying');
                    $table->enum('device_type', ['web', 'tracker'])->default('web')->nullable()->after('user_id');
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
        if (Schema::hasTable('active_users')) {
            Schema::table('active_users', function (Blueprint $table) {
                if (Schema::hasColumn('active_users', 'device_type')) {
                    $table->dropColumn('device_type');
                }
            });
        }
    }
}
