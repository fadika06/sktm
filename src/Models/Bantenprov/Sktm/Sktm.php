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
        'nomor_un',
        'master_sktm_id',
        'no_sktm',
        'nilai',
        'user_id',
    ];

    public function siswa()
    {
        return $this->belongsTo('Bantenprov\Siswa\Models\Bantenprov\Siswa\Siswa','nomor_un','nomor_un');
    }

    public function master_sktm()
    {
        return $this->belongsTo('Bantenprov\Sktm\Models\Bantenprov\Sktm\MasterSktm','master_sktm_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
