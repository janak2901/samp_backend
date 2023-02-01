<?php

use Centroall\Helper\Utils\CommonUtil;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "Migrating in database --> " . DB::connection()->getDatabaseName() . ' at ' . date('Y-m-d h:i A'));
        CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "Migration name --> 2022_01_27_092826_update_series_table");

        if (Schema::hasTable('series')) {
            Schema::table('series', function (Blueprint $table) {
                if (!Schema::hasColumn('series', 'increment_by')) {
                    $table->integer('increment_by')->default(1)->after('slug');

                    CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "increment_by field added in series table successfully. --> " . DB::connection()->getDatabaseName() . ' at ' . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "2022_01_27_092826_update_series_table --> increment_by column already exists in series table." . date('Y-m-d h:i A'));
                }

                if (!Schema::hasColumn('series', 'business_unit_id')) {
                    $table->unsignedBigInteger('business_unit_id')->after('name')->nullable();
                    $table->foreign("business_unit_id")->references('id')->on("business_units")->onUpdate('cascade')->onDelete('cascade');

                    CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "business_unit_id field added in series table successfully. --> " . DB::connection()->getDatabaseName() . ' at ' . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "2022_01_27_092826_update_series_table --> business_unit_id column already exists in series table." . date('Y-m-d h:i A'));
                }

                if (!Schema::hasColumn('series', 'code_preview')) {
                    $table->string('code_preview')->after('suffix');

                    CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "code_preview field added in series table successfully. --> " . DB::connection()->getDatabaseName() . ' at ' . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "2022_01_27_092826_update_series_table --> code_preview column already exists in series table." . date('Y-m-d h:i A'));
                }

                if (Schema::hasColumn('series', 'is_allow_screen_short')) {
                    $table->dropColumn('is_allow_screen_short');

                    CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "is_allow_screen_short field added in series table successfully. --> " . DB::connection()->getDatabaseName() . ' at ' . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "2022_01_27_092826_update_series_table --> is_allow_screen_short column doesn't exists in series table." . date('Y-m-d h:i A'));
                }
            });
        } else {
            CommonUtil::logRecorder('migration-logs', 'migrate-logs-' . date('Y-m-d') . '', "2022_01_27_092826_update_series_table --> Series table not found." . date('Y-m-d h:i A'));
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
        CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "Migration name --> 2022_01_27_092826_update_series_table");

        if (Schema::hasTable('series')) {
            Schema::table('series', function (Blueprint $table) {
                if (Schema::hasColumn('series', 'code_preview')) {
                    $table->dropColumn('code_preview');

                    CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "code_preview field removed from series table successfully. --> " . DB::connection()->getDatabaseName() . ' at ' . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "2022_01_27_092826_update_series_table --> code_preview column doesn't exists in series table." . date('Y-m-d h:i A'));
                }

                if (!Schema::hasColumn('series', 'is_allow_screen_short')) {
                    $table->boolean('is_allow_screen_short')->after('next_number');

                    CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "is_allow_screen_short field added in series table successfully. --> " . DB::connection()->getDatabaseName() . ' at ' . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "2022_01_27_092826_update_series_table --> is_allow_screen_short column already exists in series table." . date('Y-m-d h:i A'));
                }
            });
        } else {
            CommonUtil::logRecorder('migration-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "2022_01_27_092826_update_series_table --> Series table not found." . date('Y-m-d h:i A'));
        }
    }
}