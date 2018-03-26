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
        'nomor_un',
        'kode_sktm',
        'nama_suket',
        'instansi_suket',
        'no_suket',
        'nilai_sktm'
    ];

     public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
