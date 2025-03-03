<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


/**
 * @property int $id
 * @property string $lastName
 * @property string $firstName
 * @property string $image
 * @property \Carbon\Traits\Timestamp $created_at
 * @property \Carbon\Traits\Timestamp $updated_at
 */
class Profile extends Model
{

    protected $table = "profiles";

    protected $connection = "mysql";

    protected $primaryKey = "id";


    protected $fillable = [
        'lastname',
        'firstname',
        'image',
        'status',
        'created_at',
        'updated_at'
    ];

    /**
     * Get profile first name
     */
    protected function firstName(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucfirst($value),
        );
    }


    /**
     * Get profile last name
     */
    protected function lastName(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucfirst($value),
        );
    }
}
