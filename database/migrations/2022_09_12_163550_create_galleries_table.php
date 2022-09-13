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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('file_path')->nullable();
            $table->unsignedBigInteger('file_type')->default(1)->comment('1 = Image, 2 = Video, 3 = Audio');
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
        Schema::dropIfExists('galleries');
    }
};
