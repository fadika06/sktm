<?php

namespace Bantenprov\Sktm\Models\Bantenprov\Sktm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterSktm extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'master_sktms';
    protected $dates = [
        'deleted_at'
    ];
    protected $fillable = [
        'user_id',
        'juara',
        'tingkat',
        'nama_lomba',
        'nilai',
        'bobot'
    ];

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
