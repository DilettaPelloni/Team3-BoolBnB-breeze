<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'title_slug',
        'description',
        'rooms',
        'beds',
        'bathrooms',
        'size',
        'address',
        'address_slug',
        // 'latitude',
        // 'longitude',
        'cover_img',
        'visible',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function services() {
        return $this->belongsToMany(Service::class);
    }

    public function sponsorships() {
        return $this->belongsToMany(Sponsorship::class);
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }
}
