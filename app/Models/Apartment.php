<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'n_rooms', 'n_beds', 'n_bathrooms', 'squared_meters', 'image', 'is_visible', 'description', 'address', 'latitude', 'longitude', 'user_id', 'slug'];

    public function sponsorships()
    {
        return $this->belongsToMany(Sponsorship::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
