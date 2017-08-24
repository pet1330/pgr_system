<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
    use Spatie\Activitylog\Traits\LogsActivity;

class AbsenceType extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected static $logOnlyDirty = true;

    protected static $logAttributes = [ 'name', 'interuption' ];

    protected $fillable = ['name', 'interuption'];

    protected $table = 'absence_types';

    protected $dates = ['deleted_at'];

    public function absence()
    {
        return $this->hasMany(Absence::class);
    }
}
