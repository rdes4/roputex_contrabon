<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContrabonFakturModel extends Model
{
    use HasFactory;
    protected $table = 'contrabon_faktur';
    protected $guarded = [];
}
