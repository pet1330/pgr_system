<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
    use Spatie\Activitylog\Traits\LogsActivity;

class Programme extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected static $logOnlyDirty = true;

    protected static $logAttributes = [ 'name', 'duration', 'duration_unit' ];

    protected $fillable = ['name', 'duration', 'duration_unit'];

    protected $table = 'programmes';

    protected $dates = ['deleted_at'];

    public function students()
    {
        return $this->hasMany(StudentRecord::class);
    }
}
