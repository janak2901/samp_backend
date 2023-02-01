<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!(Schema::hasTable('organization_masters'))) {
            Schema::create('organization_masters', function (Blueprint $table) {
                $table->id();
                $table->string('email');
                $table->boolean('is_valid_email')->default(0);
                $table->boolean('is_check_email')->default(0);
                $table->string('otp', 245);
                $table->dateTime('otp_time');
                $table->boolean('is_verified')->default(0);
                $table->string('organization_name')->nullable();
                $table->string('phone_no')->nullable();
                $table->string('database_name')->nullable();
                $table->string('domain_name')->nullable();
                $table->integer('employee_strength')->nullable();
                $table->string('country')->nullable();
                $table->string('state')->nullable();
                $table->string('city')->nullable();
                $table->boolean('is_database_import')->default(0);
                $table->integer('current_level')->default(0);
                $table->boolean('is_onborading_complate')->default(0);
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
        Schema::dropIfExists('organization_masters');
    }
}
