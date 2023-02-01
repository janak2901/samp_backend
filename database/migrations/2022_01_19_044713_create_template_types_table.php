<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('template_types')) {
            Schema::create('template_types', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('group_template_id')->nullable();
                $table->string('name');
                $table->text('description');
                $table->text('content');
                $table->boolean('is_authorised')->default(0);
                $table->text('authorised_person_details');
                $table->boolean('is_publish')->default(0);
                $table->boolean('is_active')->default(1);
                $table->boolean('is_archive')->default(0);
                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('archive_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();
                $table->foreign("group_template_id")->references('id')->on("group_templates")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("created_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("updated_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("archive_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("deleted_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->timestamps();
                $table->dateTime('archive_at')->nullable();
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
        Schema::dropIfExists('template_types');
    }
}