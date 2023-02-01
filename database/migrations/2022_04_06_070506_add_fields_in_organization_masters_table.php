<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsInOrganizationMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('organization_masters')) {
            Schema::table('organization_masters', function (Blueprint $table) {
                if (!Schema::hasColumn('organization_masters', 'business_domain')) {
                    $table->string('business_domain')->nullable()->after('email');
                }
                if (!Schema::hasColumn('organization_masters', 'registeration_number')) {
                    $table->string('registeration_number')->nullable()->after('business_domain');
                }
                if (!Schema::hasColumn('organization_masters', 'secondary_phone_no')) {
                    $table->string('secondary_phone_no')->nullable()->after('registeration_number');
                }
                if (!Schema::hasColumn('organization_masters', 'website')) {
                    $table->string('website')->nullable()->after('secondary_phone_no');
                }
                if (!Schema::hasColumn('organization_masters', 'about_the_company')) {
                    $table->text('about_the_company')->nullable()->after('website');
                }
                if (!Schema::hasColumn('organization_masters', 'about_the_vision')) {
                    $table->text('about_the_vision')->nullable()->after('about_the_company');
                }
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
        if (Schema::hasTable('organization_masters')) {
            Schema::table('organization_masters', function (Blueprint $table) {
                if (Schema::hasColumn('organization_masters', 'business_domain')) {
                    $table->dropColumn('business_domain');
                }
                if (Schema::hasColumn('organization_masters', 'registeration_number')) {
                    $table->dropColumn('registeration_number');
                }
                if (Schema::hasColumn('organization_masters', 'secondary_phone_no')) {
                    $table->dropColumn('secondary_phone_no');
                }
                if (Schema::hasColumn('organization_masters', 'website')) {
                    $table->dropColumn('website');
                }
                if (Schema::hasColumn('organization_masters', 'about_the_company')) {
                    $table->text('about_the_company');
                }
                if (Schema::hasColumn('organization_masters', 'about_the_vision')) {
                    $table->text('about_the_vision');
                }
            });
        }
    }
}