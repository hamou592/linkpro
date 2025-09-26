<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'phone',
        'color',
        'logo_path',
        'background_path',
        'links',
        'geolocation'
    ];

    // Keep links and geolocation as arrays (stored as JSON in DB)
    protected $casts = [
        'links' => 'array',
        'geolocation' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
