<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFieldsInEncashmentRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // \Config::set('database.connections.mysql.database', 'aarzooco_centroall');
        // DB::purge('mysql');

        if (Schema::hasTable('encashment_records')) {
            Schema::table('encashment_records', function (Blueprint $table) {
                if (Schema::hasColumn('encashment_records', 'payslip_id')) {
                    $table->unsignedBigInteger('payslip_id')->nullable()->change();
                }
                if (Schema::hasColumn('encashment_records', 'id_paid')) {
                    $table->renameColumn('id_paid', 'is_paid');
                }
                //dd(!Schema::hasColumn('encashment_records', 'created_at') && !Schema::hasColumn('encashment_records', 'updated_at'));
                if (!Schema::hasColumn('encashment_records', 'created_at') && !Schema::hasColumn('encashment_records', 'updated_at')) {
                    $table->timestamps();
                }
                if (!Schema::hasColumn('encashment_records', 'deleted_at')) {
                    $table->softDeletes();
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
        if (Schema::hasTable('encashment_records')) {
            Schema::table('encashment_records', function (Blueprint $table) {
                if (Schema::hasColumn('encashment_records', 'payslip_id')) {
                    $table->unsignedBigInteger('payslip_id')->nullable()->change();
                }
                if (Schema::hasColumn('encashment_records', 'id_paid')) {
                    $table->rename('is_paid', 'id_paid');
                }
                if (Schema::hasColumn('encashment_records', 'created_at') && Schema::hasColumn('encashment_records', 'updated_at')) {
                    $table->dropColumn('created_at');
                    $table->dropColumn('updated_at');
                }
                if (Schema::hasColumn('encashment_records', 'deleted_at')) {
                    $table->dropColumn('deleted_at');
                }
            });
        }
    }
}