<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'n_rooms', 'n_beds', 'n_bathrooms', 'm2', 'image', 'is_visible', 'description', 'address', 'latitude', 'longitude', 'user_id'];

    public function sponsorships()
    {
        return $this->belongsToMany(Sponsorship::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
}
