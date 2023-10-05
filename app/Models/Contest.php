<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Participant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contest extends Model
{
    use HasFactory;

    protected $table = "contests";
    protected $guarded = [];
    protected $appends = ['date_held_display'];

    public function getDateHeldDisplayAttribute()
    {
        $date_held = $this->attributes['date_held'] ?? '';
        if($date_held) {
            return Carbon::parse($date_held)->format('d M Y');
        }

        return '';
    }

    public function contest_participants()
    {
        return $this->hasMany(Participant::class, 'contest_id');
    }
}
