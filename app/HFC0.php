<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HFC0 extends Model
{
    protected $table = 'hf_c0';
    protected $fillable = [
        'tank11C0', 'tank12C0', 'tank22C0',
    ];
}
