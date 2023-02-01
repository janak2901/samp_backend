<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOvertimePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!(Schema::hasTable('overtime_policies'))) {
            Schema::create('overtime_policies', function (Blueprint $table) {
                $table->id();
                $table->string("slug", 50);
                $table->string("name", 50);
                $table->enum("overtime_payout", ['none', '1x', '1.5x', '2x', 'custom'])->nullable();
                $table->string('payout_value')->nullable();
                $table->string('note')->nullable();
                $table->time("rule_for_overtime")->nullable();
                $table->boolean("is_allowed_training")->default(0);
                $table->boolean("is_allowed_probation")->default(0);
                $table->boolean("is_allowed_notice")->default(0);
                $table->boolean("is_reporting_person")->default(0);
                $table->boolean("is_hr")->default(0);
                $table->boolean("status")->default(1);
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
        Schema::dropIfExists('overtime_policies');
    }
}