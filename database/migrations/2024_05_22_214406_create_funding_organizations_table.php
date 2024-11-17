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
        Schema::create('funding_organizations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image');
            $table->string('name_ar');
            $table->string('name_en');
            $table->longText('offer_ar');
            $table->longText('offer_en');
            $table->boolean('status');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('funding_organizations');
    }
};
