<?php

namespace App\Models;

use Balping\HashSlug\HasHashSlug;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Media extends \Plank\Mediable\Media
{
    use HasHashSlug;
    use LogsActivity;
    use SoftDeletes;

    protected $with = ['uploader'];

    protected static $logOnlyDirty = true;

    protected static $logAttributes = [
        'disk',
        'size',
        'filename',
        'directory',
        'extension',
        'mime_type',
        'uploader_id',
        'aggregate_type',
        'original_filename',
    ];

    public function getIconAttribute()
    {
        switch ($this->aggregate_type) {
            case 'video': return 'fa-file-video-o';
            case 'audio': return 'fa-file-audio-o';
            case 'archive': return 'fa-file-archive-o';
            case 'image': return 'fa-file-image-o';
            case 'presentation': return 'fa-file-powerpoint-o';
            case 'spreadsheet': return 'fa-file-excel-o';
            case 'document': return 'fa-file-word-o';
            case 'pdf': return 'fa-file-pdf-o';
            default: return 'fa-file-text-o';
        }
    }

    public function uploader()
    {
        return $this->belongsTo(User::class);
    }

    public function setOriginalNameAttribute($name)
    {
        $this->attributes['original_filename'] = str_replace(['#', '?', '\\'], '-', $name);
    }
}
