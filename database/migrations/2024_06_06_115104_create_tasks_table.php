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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("image")->nullable();
            $table->text("tags")->nullable();
            $table->text("data")->nullable();
            $table->unsignedBigInteger("user_list_id");
            $table->foreign("user_list_id")->references('id')->on('public.user_lists');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
