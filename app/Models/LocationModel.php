<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocationModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'location';
    protected $primaryKey = 'location_id';

    protected $fillable =
    [
       'location',
       'contact_no'
    ];
}
