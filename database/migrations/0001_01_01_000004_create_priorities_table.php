<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('priorities', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // Low, Medium, High, Urgent
            $table->string('color', 7);       // hex color for badge
            $table->unsignedTinyInteger('level'); // 1=low, 2=medium, 3=high, 4=urgent
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('priorities');
    }
};
