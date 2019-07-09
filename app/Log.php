<?php

namespace App;

use Monolog\Logger;

class Log extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'level',
        'message',
        'context',
        'ip_address',
        'user_agent',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'context' => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['level_name'];

    /**
     * Get the log's level name.
     *
     * @return string
     */
    public function getLevelNameAttribute()
    {
        return strtolower(Logger::getLevelName($this->level));
    }

    /**
     * Get the user that owns the log.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
