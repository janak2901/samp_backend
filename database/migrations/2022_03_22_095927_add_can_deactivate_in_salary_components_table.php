<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCanDeactivateInSalaryComponentsTable extends Migration
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
                if (!Schema::hasColumn('salary_components', 'can_deactivate')) {
                    $table->boolean('can_deactivate')->default(1)->after('category');
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
                if (Schema::hasColumn('salary_components', 'can_deactivate')) {
                    $table->dropColumn('can_deactivate');
                }
            });
        }
    }
}