<?php

namespace Bantenprov\Sktm\Models\Bantenprov\Sktm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sktm extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'sktms';
    protected $fillable = [
        'nomor_un',
        'master_sktm_id',
        'no_sktm',
        'nilai',
        'user_id',
    ];
    protected $hidden = [
    ];
    protected $appends = [
        'label',
    ];
    protected $dates = [
        'deleted_at',
    ];

    public function getLabelAttribute()
    {
        if ($this->siswa !== null) {
            return $this->siswa->nomor_un.' - '.$this->siswa->nama_siswa;
        } else {
            return $this->nomor_un.' - ';
        }
    }

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
