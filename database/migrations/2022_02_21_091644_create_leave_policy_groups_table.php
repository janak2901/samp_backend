<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavePolicyGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!(Schema::hasTable('leave_policy_groups'))) {
            Schema::create('leave_policy_groups', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('leave_policy');
                $table->foreign("leave_policy")->references('id')->on('leave_policies')->onUpdate('cascade')->onDelete('cascade');
                $table->unsignedBigInteger('leave_type');
                $table->foreign("leave_type")->references('id')->on('leave_types')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('leave_policy_groups');
    }
}