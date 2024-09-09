<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Stadium extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 'stadia';
    protected $casts = [
        'tenants' => 'array',
    ];
    
    protected $fillable = [
        'name', //
        'slug',
        'full_name', //
        'address',
        'zip_code',
        'phone_number', //
        'email', //
        'website', //
        'services',
        'amenities',
        'features',
        'location_description',
        'facilities',
        'stadium_rating',
        'recreational_facilities',
        'restaurants',
        'bars',
        'themed_areas',
        'events',
        'history',
        'photo_1',
        'photo_2',
        'photo_3',
        'country',
        'state',
        'city',
        'capacity', //
        'construction_price',
        'construction_start_date',
        'construction_end_date',
        'tenants',
        'sport_id',
        'latitude',
        'longitude',
        'location',
    ];

    protected $appends = [
        'address',
        'location',
    ];    
    public function getAddressAttribute(): array
    {
        return [
            "lat" => (float)$this->latitude,
            "lng" => (float)$this->longitude,
        ];
    }
    public function getLocationAttribute(?array $location): void
    {
        if (is_array($location))
        {
            $this->attributes['latitude'] = $location['lat'];
            $this->attributes['longitude'] = $location['lng'];
            unset($this->attributes['location']);
        }
    }

    public static function getLatLngAttributes(): array
    {
        return [
            'lat' => 'latitude',
            'lng' => 'longitude',
        ];
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name', 'id']);
    }
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
    public function sport(): BelongsToMany
    {
        return $this->belongsToMany(Sport::class);
    }
    
}
