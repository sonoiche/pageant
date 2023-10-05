<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantPoint extends Model
{
    use HasFactory;

    protected $table = "participant_points";
    protected $guarded = [];
    protected $appends = [];
}
