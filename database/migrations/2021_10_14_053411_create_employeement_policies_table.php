<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeementPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!(Schema::hasTable('employeement_policies'))) {

            Schema::create('employeement_policies', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger("employeement_type_id");
                $table->foreign("employeement_type_id")->references('id')->on("employeement_types")->onUpdate('cascade')->onDelete('cascade');
                $table->string("slug", 50);
                $table->string("name", 50);
                $table->boolean("is_allowed_overtime")->default(0);
                $table->boolean("is_allowed_paid_leave")->default(0);
                $table->boolean("status")->default(0);
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
        Schema::dropIfExists('employeement_policies');
    }
}
