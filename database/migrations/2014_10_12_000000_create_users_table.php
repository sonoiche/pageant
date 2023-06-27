<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('lname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->enum('status', ['Active','Inactive'])->nullable();
            $table->string('photo')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        $data = [
            ['fname' => 'Admin', 'lname' => 'User', 'email' => 'admin@gmail.com', 'password' => bcrypt('12345678'), 'status' => 'Active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ];

        DB::table('users')->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
