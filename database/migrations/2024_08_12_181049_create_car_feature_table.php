<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarFeatureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_feature', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained()->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreignId('feature_id')->constrained()->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->text('description_ar');
            $table->text('description_en');
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
        Schema::dropIfExists('car_feature');
    }
}
