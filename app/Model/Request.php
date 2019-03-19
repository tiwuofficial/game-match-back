<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from_id', 'to_id'
    ];

    public function fromUser()
    {
        return $this->belongsTo('App\Model\User', 'from_id');
    }
}
