<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TechEvents extends Model
{
    protected $table = 'tech_events';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'starts',
        'ends',
        'status',
        'summary',
        'location',
        'uid'
    ];
    
    /**
     * The rules for data entry
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'starts' => 'required',
        'ends' => 'required',
        'status' => 'required',
        'summary' => 'required',
        'location' => 'required',
        'uid' => 'required'
    ];
}
