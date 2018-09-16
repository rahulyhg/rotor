<?php

namespace App\Models;

/**
 * Class Status
 *
 * @property int id
 * @property int topoint
 * @property int point
 * @property string name
 * @property string color
 */
class Status extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'status';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

}
