<?php

namespace App\Models;

use Balping\HashSlug\HasHashSlug;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbsenceType extends Model
{
    use HasHashSlug;
    use SoftDeletes;
    use LogsActivity;

    protected static $logOnlyDirty = true;

    protected static $logAttributes = ['name', 'interuption'];

    protected $fillable = ['name', 'interuption'];

    protected $table = 'absence_types';

    protected $dates = ['deleted_at'];

    public function absence()
    {
        return $this->hasMany(Absence::class);
    }
}
