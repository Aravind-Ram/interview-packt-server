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
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('author_name', 150)->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number', 12)->nullable();
            $table->string('address', 200)->nullable();
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
        Schema::dropIfExists('authors');
    }
};
