<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Journey extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'journey';

    protected $fillable = [
        'origin',
        'destiny',
        'datetime_start',
        'datetime_end',
        'quotas',
        'price',
        'status',
        'description',
        'vehicle_plate'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
