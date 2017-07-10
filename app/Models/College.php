<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    protected $fillable = [ 'name' ];
    protected $table = 'colleges';

    public function schools()
    {
        return $this->hasMany(School::class, 'college_id', 'id');
    }
}
