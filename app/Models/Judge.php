<?php

namespace App\Models;

use App\Models\Contest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Judge extends Model
{
    use HasFactory;

    protected $table = "judges";
    protected $guarded = [];
    protected $appends = ['fullname'];

    public function getFullnameAttribute()
    {
        $fname = $this->attributes['fname'] ?? '';
        $lname = $this->attributes['lname'] ?? '';

        if($fname && $lname) {
            return $fname.' '.$lname;
        }

        return '';
    }

    public function contest()
    {
        return $this->belongsTo(Contest::class, 'contest_id');
    }
}
