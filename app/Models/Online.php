<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Class Online
 *
 * @property int id
 * @property string ip
 * @property string brow
 * @property int updated_at
 * @property int user_id
 */
class Online extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'online';

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
