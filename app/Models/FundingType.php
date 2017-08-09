<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FundingType extends Model
{

    use SoftDeletes;

    protected $fillable = ['name'];

    protected $table = 'funding_types';

    protected $dates = ['deleted_at'];

    public function students()
    {
        return $this->hasMany(StudentRecord::class);
    }
}
