<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackerActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!(Schema::hasTable('tracker_activities'))) {

            Schema::create('tracker_activities', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('tracker_memo_id')->nullable();
                $table->unsignedBigInteger('project_id')->nullable();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('project_task_id')->nullable();
                $table->dateTime('start_date');
                $table->dateTime('end_date')->nullable();
                $table->string('duration')->nullable();
                $table->text('keyboard_mouse_count')->nullable();
                $table->string('productivity')->nullable();
                $table->string('productive_duration')->nullable();
                $table->boolean('is_manual_entry')->nullable();
                $table->unsignedBigInteger('created_by');
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();
                $table->foreign("created_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("updated_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("deleted_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("tracker_memo_id")->references('id')->on("tracker_memos")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("project_id")->references('id')->on("projects")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("user_id")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("project_task_id")->references('id')->on("project_tasks")->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tracker_activities');
    }
}
