<?php

namespace App\Models;

use Plank\Mediable\Mediable;
use Balping\HashSlug\HasHashSlug;

class Media extends \Plank\Mediable\Media
{
    use HasHashSlug;

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
}
