<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!(Schema::hasTable('targets'))) {
            Schema::create('targets', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger("goal_id");
                $table->string("name", 245);
                $table->enum("type_of_target", ["number", "true/false", "currency", "task"]);
                $table->unsignedBigInteger("added_by");
                $table->integer("start_number");
                $table->integer("end_number");
                $table->boolean("is_archive");
                $table->unsignedBigInteger('created_by');
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();
                $table->foreign("created_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("updated_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("deleted_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("added_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("goal_id")->references('id')->on("goals")->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('target');
    }
}
