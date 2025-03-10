<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $lastName
 * @property string $firstName
 * @property string $image
 * @property Status $status
 * @property Timestamp $created_at
 * @property Timestamp $updated_at
 */
class Profile extends Model
{
    use HasFactory;

    public const BASLINE_IMAGE_PROFILE_PATH = 'baseline_image.jpg';

    protected $table = 'profiles';

    protected $primaryKey = 'id';

    protected $fillable = [
        'lastName',
        'firstName',
        'image',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'status' => Status::class,
    ];

    protected $attributes = [
        'status' => Status::PENDING,
    ];

    /**
     * Get profile first name
     */
    protected function firstName(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
        );
    }

    /**
     * Get profile last name
     */
    protected function lastName(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
        );
    }
}
