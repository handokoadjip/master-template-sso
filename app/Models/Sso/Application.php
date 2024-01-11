<?php

namespace App\Models\Sso;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    use \App\Traits\TraitUuid;

    protected $connection = 'sso';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'aplikasi';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'aplikasi_id';

    const CREATED_AT = 'aplikasi_dibuat_pada';
    const UPDATED_AT = 'aplikasi_diubah_pada';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'aplikasi_kategori_id',
        'aplikasi_nama',
        'aplikasi_ikon',
        'aplikasi_ikon_normal',
        'aplikasi_tautan',
        'aplikasi_jenis',
        'aplikasi_backoffice',
        'aplikasi_dibuat_pengguna_id',
    ];

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'grup_aplikasi', 'grup_aplikasi_aplikasi_id', 'grup_aplikasi_grup_id');
    }

    public function applicationRoles()
    {
        return $this->hasMany(ApplicationRole::class, 'aplikasi_peran_aplikasi_id');
    }
}
