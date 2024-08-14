<?php

use App\Models\Sport;
use App\Models\Stadium;
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
        Schema::create('sport_stadium', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Stadium::class)->cascadeOnDelete();;
            $table->foreignIdFor(Sport::class)->cascadeOnDelete();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sport_stadium');
    }
};
