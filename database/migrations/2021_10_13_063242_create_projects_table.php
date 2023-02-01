<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!(Schema::hasTable('projects'))) {
            Schema::create('projects', function (Blueprint $table) {
                $table->id();
                $table->string("slug", 50);
                $table->string("name", 50);
                $table->enum("type", ['Fixed', 'Hours', 'Support'])->nullable();
                $table->date("delivery_date")->nullable();
                $table->integer("estimated_days")->nullable();
                $table->unsignedBigInteger("pm_id")->nullable();
                $table->string('profile_pic')->nullable();
                $table->unsignedBigInteger('parent_project_id')->nullable();
                $table->foreign("parent_project_id")->references('id')->on("projects")->onUpdate('cascade')->onDelete('cascade');
                $table->unsignedBigInteger('deal_size')->nullable();
                $table->boolean('status')->default(1);
                $table->unsignedBigInteger('created_by');
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();
                $table->foreign("deal_size")->references('id')->on("deal_sizes")->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('project');
    }
}