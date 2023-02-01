<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalarySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('salary_settings')) {
            Schema::create('salary_settings', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('organisation_id');
                $table->foreign("organisation_id")->references('id')->on("organisations")->onUpdate('cascade')->onDelete('cascade');
                $table->boolean('show_salary_mode')->default(0);
                $table->boolean('enable_pf_mode')->default(0);
                $table->boolean('loss_of_pays_mode')->default(0);
                $table->timestamps();
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
        Schema::dropIfExists('salary_settings');
    }
}
