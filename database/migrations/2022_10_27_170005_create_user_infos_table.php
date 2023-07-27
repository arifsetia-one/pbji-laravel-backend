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
        Schema::create('user_infos', function (Blueprint $table) {
            // $table->id();
            // $table->uuid('uuid');
            $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->string('postal_code')->nullable();
            $table->string('village_name')->nullable();
            $table->string('urban_village')->nullable();    // kelurahan
            $table->string('sub_district')->nullable();     // kecamatan
            $table->string('city_name')->nullable();        // kota
            $table->string('province')->nullable();         // provinsi
            $table->string('full_addresses')->nullable();
            $table->integer('phone_number')->nullable();
            $table->integer('whatsapp_number')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_infos');
    }
};
