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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign(['car_id'])->references(['id'])->on('cars')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['nationality_id'])->references(['id'])->on('nationalities')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['status_id'])->references(['id'])->on('setting_order_statuses')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['city_id'])->references(['id'])->on('cities')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['employee_id'])->references(['id'])->on('employees')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['opened_by'])->references(['id'])->on('employees')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_car_id_foreign');
            $table->dropForeign('orders_nationality_id_foreign');
            $table->dropForeign('orders_status_id_foreign');
            $table->dropForeign('orders_city_id_foreign');
            $table->dropForeign('orders_employee_id_foreign');
            $table->dropForeign('orders_opened_by_foreign');
        });
    }
};
