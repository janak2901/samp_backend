<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatutoryComponentIdInSalaryComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('salary_components')) {
            Schema::table('salary_components', function (Blueprint $table) {
                if (!Schema::hasColumn('salary_components', 'statutory_pf_component')) {
                    $table->unsignedBigInteger('statutory_pf_component')->after('status')->nullable();
                    $table->foreign("statutory_pf_component")->references('id')->on("statutory_pf_components")->onUpdate('cascade')->onDelete('cascade');
                }
                if (!Schema::hasColumn('salary_components', 'statutory_esic_component')) {
                    $table->unsignedBigInteger('statutory_esic_component')->after('statutory_pf_component')->nullable();
                    $table->foreign("statutory_esic_component")->references('id')->on("statutory_esic_components")->onUpdate('cascade')->onDelete('cascade');
                }
                if (!Schema::hasColumn('salary_components', 'statutory_prof_tax_component')) {
                    $table->unsignedBigInteger('statutory_prof_tax_component')->after('statutory_esic_component')->nullable();
                    $table->foreign("statutory_prof_tax_component")->references('id')->on("statutory_prof_tax_components")->onUpdate('cascade')->onDelete('cascade');
                }
                if (!Schema::hasColumn('salary_components', 'statutory_tds_component')) {
                    $table->unsignedBigInteger('statutory_tds_component')->after('statutory_prof_tax_component')->nullable();
                    $table->foreign("statutory_tds_component")->references('id')->on("statutory_tds_components")->onUpdate('cascade')->onDelete('cascade');
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
        if (Schema::hasTable('salary_components')) {
            Schema::table('salary_components', function (Blueprint $table) {
                if (Schema::hasColumn('salary_components', 'statutory_pf_component')) {
                    $table->dropForeign(['statutory_pf_component']);
                    $table->dropColumn('statutory_pf_component');
                }
                if (Schema::hasColumn('salary_components', 'statutory_esic_component')) {
                    $table->dropForeign(['statutory_esic_component']);
                    $table->dropColumn('statutory_esic_component');
                }
                if (Schema::hasColumn('salary_components', 'statutory_prof_tax_component')) {
                    $table->dropForeign(['statutory_prof_tax_component']);
                    $table->dropColumn('statutory_prof_tax_component');
                }
                if (Schema::hasColumn('salary_components', 'statutory_tds_component')) {
                    $table->dropForeign(['statutory_tds_component']);
                    $table->dropColumn('statutory_tds_component');
                }
            });
        }
    }
}