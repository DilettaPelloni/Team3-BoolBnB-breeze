<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
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

    // public function services() {
    //     return $this->belongsToMany(Service::class);
    // }
}
