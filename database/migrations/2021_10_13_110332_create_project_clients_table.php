<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!(Schema::hasTable('project_clients'))) {

            Schema::create('project_clients', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger("client_id");
                $table->unsignedBigInteger("project_id")->nullable();
                $table->enum('type',['organisation','individual'])->nullable();
                $table->string('org_name')->nullable();
                $table->unsignedBigInteger('country_id')->nullable();
                $table->foreign('country_id')->references('id')->on('countries')->onUpdate('cascade')->onDelete('cascade');
                $table->unsignedBigInteger('state_id')->nullable();
                $table->foreign('state_id')->references('id')->on('states')->onUpdate('cascade')->onDelete('cascade');
                $table->unsignedBigInteger('city_id')->nullable();
                $table->foreign('city_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');
                $table->enum('status',['active','archived'])->default('active')->nullable();
                $table->boolean('is_invitation_accepted')->nullable()->default(0);
                $table->boolean('cancel_invitation')->default(0);
                $table->unsignedBigInteger('created_by');
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();
                $table->foreign("created_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("updated_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("deleted_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("client_id")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("project_id")->references('id')->on("projects")->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('project_client');
    }
}
