<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncashmentRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('encashment_records')) {
            Schema::create('encashment_records', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('payslip_id');
                $table->foreign('payslip_id')->references('id')->on('payslips')->onUpdate('cascade')->onDelete('cascade');
                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
                $table->unsignedBigInteger('leave_type_id');
                $table->foreign('leave_type_id')->references('id')->on('leave_types')->onUpdate('cascade')->onDelete('cascade');
                $table->string('month_year');
                $table->integer('total_leaves');
                $table->boolean('id_paid')->default(0);
                $table->unsignedBigInteger('created_by');
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();
                $table->foreign("created_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("updated_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("deleted_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
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
        Schema::table('encashment_records', function (Blueprint $table) {
            //
        });
    }
}