<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $table = "subscribers";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "first_name",
        "last_name",
        "phone_number",
        "tech_events_id"
    ];
    
    /**
     * The rules for data entry
     *
     * @var array
     */
    public static $rules = [
        "first_name" => "required",
        "last_name" => "required",
        "phone_number" => "required",
        "tech_events_id" => "required",
    ];

    
    /**
     * Defines the relationship with TechEvents
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function events()
    {
        return $this->belongsTo("App/Models/TechEvents");
    }
}
