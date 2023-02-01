<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! (Schema::hasTable('shifts'))) {

            Schema::create('shifts', function (Blueprint $table) {
                $table->id();
                /*$table->string("slug", 50);
                $table->string("name", 50);
                $table->string("code", 50);
                $table->time("day_start");
                $table->time("day_end");
                $table->time("break_start");
                $table->time("break_end");
                $table->boolean("status")->default(1);
                $table->timestamps();
                $table->softDeletes();*/
                $table->string("name", 50);
                $table->string("slug", 50);
                $table->boolean("monday")->default(0);
                $table->boolean("tuesday")->default(0);
                $table->boolean("wednesday")->default(0);
                $table->boolean("thursday")->default(0);
                $table->boolean("friday")->default(0);
                $table->boolean("saturday")->default(0);
                $table->boolean("sunday")->default(0);
                $table->time("day_start")->nullable();
                $table->time("day_end")->nullable();
                $table->time("break_start")->nullable();
                $table->time("break_end")->nullable();
                $table->enum("working_hours_from_saturday", ["Full Day", "Half Day", "Alternate Saturday"])->nullable();
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
        Schema::dropIfExists('shifts');
    }
}
