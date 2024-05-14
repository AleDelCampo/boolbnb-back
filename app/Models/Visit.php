<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visit extends Model
{
    use HasFactory; 

    protected $fillable = ['timestamp_visits', 'ip_address', 'apartment_id'];

    public function visits():BelongsTo
    {
        return $this->belongsTo(Apartment::class);
    }
}
