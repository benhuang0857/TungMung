<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HNO3C0 extends Model
{
    protected $table = 'hno3_c0';
    protected $fillable = [
        'tank11C0', 'tank12C0', 'tank22C0',
    ];
}
