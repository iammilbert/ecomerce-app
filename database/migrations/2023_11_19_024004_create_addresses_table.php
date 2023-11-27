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
        Schema::create('addresses', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary key 'address_id'
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate(); // Foreign key referencing Users table
            $table->foreignId('country_of_residence_id')->nullable()->constrained('countries')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('country_of_origin_id')->nullable()->constrained('countries')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('lg_of_residence_id')->nullable()->constrained('lgs')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('lg_of_origin_id')->nullable()->constrained('lgs')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('state_of_origin_id')->nullable()->constrained('states')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('state_of_resident_id')->nullable()->constrained('states')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('residential_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->timestamps(); // 'created_at' and 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
};
