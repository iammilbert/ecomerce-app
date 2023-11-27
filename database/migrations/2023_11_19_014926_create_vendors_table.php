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
        Schema::create('vendors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('company_name');
            $table->string('company_rc')->nullable();
            $table->string('company_address')->index();
            $table->foreignId('company_country_of_residence_id')->constrained('countries')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('company_lg_of_residence_id')->constrained('lgs')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('company_state_of_resident_id')->constrained('states')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('company_phone_number')->nullable()->index();
            $table->string('company_mobile_number')->index();
            $table->string('company_email')->nullable();
            $table->boolean('is_verified')->default(false)->index();
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('vendors');
    }
};
