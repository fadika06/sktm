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
        'user_id',
        'master_sktm_id',
        'nomor_un',
        'no_sktm',
        'nilai'
    ];

    public function master_sktm()
    {
        return $this->belongsTo('Bantenprov\Sktm\Models\Bantenprov\Sktm\MasterSktm','master_sktm_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
