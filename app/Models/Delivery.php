<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    // Optional: specify the table if not standard
    // protected $table = 'deliveries';

    // Allow mass assignment
    protected $fillable = ['state', 'fee'];
}
