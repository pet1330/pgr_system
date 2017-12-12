<?php

namespace App\Models;

use Plank\Mediable\Mediable;
use Balping\HashSlug\HasHashSlug;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use Mediable;
    use SoftDeletes;
    use HasHashSlug;
    use LogsActivity;

    protected static $logOnlyDirty = true;

    protected static $logAttributes = [
        'content',
        'noteable_id',
        'noteable_type'
    ];

    protected $table ='notes';

    protected $fillable = [
        'content',
        'noteable_id',
        'noteable_type',
    ];

    public function getIntroAttribute()
    {
        return $this->intro();
    }

    public function intro($length=40)
    {
        return str_limit($this->content, $length, '...');
    }

    public function noteable()
    {
        return $this->morphTo();
    }

    public function setContentAttribute($c) {
        $this->attributes['content'] = htmlentities($c);
    }

    public function getContentAttribute($c) {
        return html_entity_decode($c);
    }
}
