<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpdDetails extends Model
{
        protected $table = 'ipd_details';

    protected $primaryKey = 'sno';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'opdnumber',
        'ipdno',
        'refered_dr',
        'wordno',
        'wordtype',
        'ipdamount',
        'ipdamount_type',
    ];
}
