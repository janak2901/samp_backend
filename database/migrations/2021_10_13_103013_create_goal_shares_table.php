<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoalSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!(Schema::hasTable('goal_shares'))) {
            Schema::create('goal_shares', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger("goal_id");
                $table->unsignedBigInteger("user_id");
                $table->unsignedBigInteger('created_by');
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();
                $table->foreign("created_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("updated_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("deleted_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("goal_id")->references('id')->on("goals")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("user_id")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('goal_share');
    }
}
