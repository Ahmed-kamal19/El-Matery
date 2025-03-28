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
        Schema::create('order_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('order_id')->nullable()->index('order_notifications_order_id_foreign');
            $table->unsignedBigInteger('ad_id')->nullable()->index('order_notifications_ad_id_foreign');
            $table->unsignedBigInteger('newstatue')->nullable()->index('order_notifications_newstatue_foreign');
            $table->unsignedBigInteger('oldstatue')->nullable()->index('order_notifications_oldstatue_foreign');
            $table->boolean('is_read')->default(false);
            $table->string('type');
            $table->string('phone');
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
        Schema::dropIfExists('order_notifications');
    }
};
