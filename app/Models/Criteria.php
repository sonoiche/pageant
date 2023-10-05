<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Criteria extends Model
{
    use HasFactory;

    protected $table = "criterias";
    protected $guarded = [];
    protected $appends = ['slug_name'];

    public function getSlugNameAttribute()
    {
        $name = $this->attributes['name'] ?? '';
        if($name) {
            return Str::replace(' ', '_', Str::lower($name));
        }

        return '';
    }

    public function contest()
    {
        return $this->belongsTo(Contest::class, 'contest_id');
    }
}
