<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeePfDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!(Schema::hasTable('employee_pf_details'))) {
            Schema::create('employee_pf_details', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger("user_id");
                $table->boolean("is_pf")->default(0);
                $table->boolean("is_abry")->default(0);
                $table->string("pan_number", 10)->nullable();
                $table->string("uan_number", 20)->nullable();
                $table->string("pf_number", 20)->nullable();
                $table->string("adhar_number", 20)->nullable();
                $table->string("esic_number", 20)->nullable();
                $table->bigInteger("salary")->nullable();
                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();
                $table->foreign("created_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("updated_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("deleted_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->timestamps();
                $table->softDeletes();
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
        Schema::dropIfExists('employee_pf_details');
    }
}