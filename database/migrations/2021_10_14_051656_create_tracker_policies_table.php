<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackerPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!(Schema::hasTable('tracker_policies'))) {

            Schema::create('tracker_policies', function (Blueprint $table) {
                $table->id();
                $table->string("slug", 50);
                $table->string("name", 50);
                $table->boolean("is_allowed_screen_short");
                $table->integer("ss_start_time");
                $table->integer("ss_end_time");
                $table->integer("ideal_mouse_click");
                $table->integer("ideal_keyboard_key_press");
                $table->integer("mouse_click");
                $table->integer("keyboard_key_press");
                $table->integer("mouse_click_weightage");
                $table->integer("keyboard_click_weightage");
                $table->integer("minimum_productivity_per_activity");
                $table->string("productivity_count_type", 50);
                $table->integer("minimum_productivity_for_overtime_eligibility");
                $table->boolean('status')->default(1);
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
        Schema::dropIfExists('tracker_policies');
    }
}
