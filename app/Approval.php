<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
	protected $table = 'approvals';
    protected $fillable = [
        'user_id', 'address' ,'status', 'item', 'phone','response'
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
