<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManualTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!(Schema::hasTable('manual_times'))) {
            Schema::create('manual_times', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger("user_id");
                $table->unsignedBigInteger("project_id");
                $table->date("date");
                $table->integer("hours");
                $table->integer("minutes");
                $table->text("memo");
                $table->text("description");
                $table->enum("status",["Approve","Pending","Reject"]);
                $table->unsignedBigInteger("approve_by")->nullable();
                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();
                $table->foreign("created_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("updated_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("deleted_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("user_id")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("project_id")->references('id')->on("projects")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("approve_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('manual_times');
    }
}
