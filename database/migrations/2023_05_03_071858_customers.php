<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('customer', function (Blueprint $table) 
        {
                $table->id();
                $table->string('name');
                $table->string('surname');
                $table->boolean('phone');
                $table->boolean('address');
                $table->boolean('city');
                $table->boolean('status');
                $table->boolean('ipaddress');
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
