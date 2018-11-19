<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class TechEvents extends Model
{
    protected $table = "tech_events";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name",
        "starts",
        "ends",
        "status",
        "summary",
        "location",
        "uid"
    ];
    
    /**
     * The rules for data entry
     *
     * @var array
     */
    public static $rules = [
        "name" => "required",
        "starts" => "required",
        "ends" => "required",
        "status" => "required",
        "summary" => "required",
        "location" => "required",
        "uid" => "required"
    ];

    /**
     * Defines the relationship to the Subscriber model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscribers()
    {
        return $this->hasMany("App\Models\Subscriber");
    }
}
