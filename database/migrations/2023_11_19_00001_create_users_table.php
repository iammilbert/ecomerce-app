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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email')->unique()->index();
            $table->string('password');
            $table->string('first_name')->index();
            $table->string('last_name')->index();
            $table->string('other_names')->index()->nullable();
            $table->string('phone_number')->nullable()->index();
            $table->string('gender', 20)->nullable();
            $table->string('marital_status', 50)->nullable();
            $table->string('dob')->nullable();
            $table->boolean('is_verified')->default(false)->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('user_type')->default('user');
            $table->string('status', 40)->default('active');
            $table->timestamps(); // 'created_at' and 'updated_at'
        });


        \Illuminate\Support\Facades\DB::table('users')
            ->insert([
                'id' => \Illuminate\Support\Str::uuid(),
                'first_name' => 'Ecommerce',
                'last_name' => 'Inventory',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'user_type' => 'admin',
                'is_verified' => 1,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
