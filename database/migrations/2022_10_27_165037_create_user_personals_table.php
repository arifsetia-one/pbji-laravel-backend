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
        Schema::create('user_personals', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->string('fullname');
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', [0, 1])->nullable();   // 1: laki-laki, 2: perempuan
            $table->integer('body_weight')->nullable();
            $table->integer('body_height')->nullable();
            $table->tinyInteger('age')->nullable();
            $table->string('medical_history')->nullable();
            $table->string('injury_history')->nullable();
            $table->string('photo_url')->nullable();
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
        Schema::dropIfExists('user_personals');
    }
};
