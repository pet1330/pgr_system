<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbsenceType extends Model
{
    
    use SoftDeletes;

    protected $fillable = ['name', 'interuption'];

    protected $table = 'absence_types';

    protected $dates = ['deleted_at'];

    public function absence()
    {
        return $this->hasMany(Absence::class);
    }
}
