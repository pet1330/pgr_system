<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class College extends Model
{
    use SoftDeletes;
    use LogsActivity;
    
    protected static $logOnlyDirty = true;
    
    protected static $logAttributes = [ 'name' ];
    
    protected $fillable = [ 'name' ];
    
    protected $table = 'colleges';

    public function schools()
    {
        return $this->hasMany(School::class, 'college_id', 'id');
    }
}
