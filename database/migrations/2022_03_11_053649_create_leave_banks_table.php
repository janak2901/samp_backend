<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('leave_banks')) {
            Schema::create('leave_banks', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('leave_policy');
                $table->foreign("leave_policy")->references('id')->on('leave_policies')->onUpdate('cascade')->onDelete('cascade');
                $table->unsignedBigInteger('leave_type');
                $table->foreign("leave_type")->references('id')->on('leave_types')->onUpdate('cascade')->onDelete('cascade');
                $table->unsignedBigInteger('user_id');
                $table->foreign("user_id")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->float('total_quota')->default(0);
                $table->float('left_quota')->default(0);
                $table->unsignedBigInteger('created_by');
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
        Schema::dropIfExists('leave_banks');
    }
}