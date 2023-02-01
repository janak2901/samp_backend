<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('projects')) {
            Schema::table(
                'projects',
                function (Blueprint $table) {
                    if (!Schema::hasColumn('projects', 'archived_at')) {
                        $table->timestamp('archived_at')->nullable()->after('updated_at');
                    }
                }
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('projects')) {
            Schema::table(
                'projects',
                function (Blueprint $table) {
                    if (Schema::hasColumn('projects', 'archived_at')) {
                        $table->dropColumn('archived_at');
                    }
                }
            );
        }
    }
}