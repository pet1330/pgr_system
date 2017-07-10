<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [ 'name', 'college_id' ];
    protected $table = 'schools';

    public function college()
    {
        return $this->belongsTo(College::class);
    }
}
