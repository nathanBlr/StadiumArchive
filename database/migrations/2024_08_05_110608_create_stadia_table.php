<?php

use App\Models\City;
use App\Models\Country;
use App\Models\Sport;
use App\Models\State;
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
        Schema::create('stadia', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('full_name')->nullable();
            $table->string('address');
            $table->string('zip_code')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->longText('services')->nullable();
            $table->longText('amenities')->nullable();
            $table->longText('features')->nullable();
            $table->longText('location_description')->nullable();
            $table->longText('facilities')->nullable();
            $table->longText('recreational_facilities')->nullable();
            $table->longText('restaurants')->nullable();
            $table->longText('bars')->nullable();
            $table->longText('themed_areas')->nullable();
            $table->longText('events')->nullable();
            $table->longText('history')->nullable();
            $table->string('photo_1')->nullable();
            $table->string('photo_2')->nullable();
            $table->string('photo_3')->nullable();
            $table->integer('stadium_rating');
            $table->string('country'); // Change this to store country names
            $table->string('state');   // Change this to store state names
            $table->string('city');    // Change this to store city names
            $table->bigInteger('capacity')->nullable();
            $table->unsignedBigInteger('construction_price')->nullable();
            $table->date('construction_start_date')->nullable();
            $table->date('construction_end_date')->nullable();
            $table->longText('tenants')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stadia');
    }
};
