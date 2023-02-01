<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationPolicyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!(Schema::hasTable('organization_policy_details'))) {
            Schema::create('organization_policy_details', function (Blueprint $table) {
                $table->id();
                $table->foreignId('organization_policy_id')
                    ->constrained('organization_policies')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
                $table->string('slug');
                $table->string('name');
                $table->text('description');
                $table->text('default_description')->nullable();
                $table->boolean('is_updated')->default(0);
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
        Schema::dropIfExists('organization_policy_details');
    }
}
