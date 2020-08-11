<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'owner_id',
        'name',
        'color',
        'slug',
        'description',
        'duration',
        'timezone',
        'disabled',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'disabled' => 'boolean',
    ];

    /**
     * @var string[]
     */
    protected $with = [
        'owner',
        'availabilities',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function availabilities()
    {
        return $this->hasMany(Availability::class, 'event_type_id');
    }
}
