<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pasient_details extends Model
{
    use HasFactory;
    
    protected $table = 'pasient_details';

    protected $primaryKey = 'sno';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'sr',
        'opdId',
        'pdate',
        'ptime',
        'pesientname',
        'gender',
        'age',
        'ymd',
        'fatherhusband',
        'mobileno',
        'address',
        'area',
        'caste',
        'desease',
        'mlc_pmlc',
        'charges',
        'chargesamount',
        'tags',
        'free_option'
    ];
}
