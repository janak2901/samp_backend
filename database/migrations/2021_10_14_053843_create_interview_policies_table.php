<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!(Schema::hasTable('interview_policies'))) {

            Schema::create('interview_policies', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger("designation_id");
                $table->unsignedBigInteger("employeement_type_id");
                $table->string("slug", 50);
                $table->string("name", 50);
                $table->text("description");
                $table->integer("round");
                $table->unsignedBigInteger('created_by');
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();
                $table->foreign("created_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("updated_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("deleted_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("designation_id")->references('id')->on("designations")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("employeement_type_id")->references('id')->on("employeement_types")->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('interview_policies');
    }
}
