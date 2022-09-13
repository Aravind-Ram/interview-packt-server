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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('title', 200)->nullable();
            $table->string('slug', 200)->nullable();
            $table->foreignId('author_id')->nullable()->constrained('authors')->restrictOnDelete();
            $table->foreignId('genre_id')->nullable()->constrained('genres')->restrictOnDelete();
            $table->foreignId('publisher_id')->nullable()->constrained('publishers')->restrictOnDelete();
            $table->string('description', 200)->nullable();
            $table->string('isbn', 20)->nullable();
            $table->string('image')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->unsignedTinyInteger('status')->nullable()->default(ITEM_STATUS_ACTIVE)->comment('1 = Active, 0 = Inactive');
            $table->timestamps();
            $table->softDeletesTz($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
};
