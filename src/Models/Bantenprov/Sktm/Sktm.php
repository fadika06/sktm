<?php

namespace Bantenprov\Sktm\Models\Bantenprov\Sktm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sktm extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'sktms';
    protected $dates = [
        'deleted_at'
    ];
    protected $fillable = [
        'label',
        'description'
    ];
}
