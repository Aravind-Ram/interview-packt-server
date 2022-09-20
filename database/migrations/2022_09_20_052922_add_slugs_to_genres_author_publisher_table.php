<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('genres', function (Blueprint $table) {
            $table->string('slug', 200)->nullable()->after('uuid');
        });

        Schema::table('authors', function (Blueprint $table) {
            $table->string('slug', 200)->nullable()->after('uuid');
        });

        Schema::table('publishers', function (Blueprint $table) {
            $table->string('slug', 200)->nullable()->after('uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('genres_author_publisher', function (Blueprint $table) {
            Schema::table('genres', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
    
            Schema::table('authors', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
    
            Schema::table('publishers', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        });
    }
};
