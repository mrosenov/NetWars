<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HackedNetworks extends Model
{
    protected $fillable = [
        'user_id',
        'network_id',
        'user',
        'password',
        'ip',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function network()
    {
        return $this->belongsTo(UserNetwork::class, 'network_id');
    }


}
