<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;
    use \App\Traits\TraitUuid;

    protected $connection = 'master_mahasiswa';
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fakultas';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'fakultas_id';

    const CREATED_AT = 'fakultas_dibuat_pada';
    const UPDATED_AT = 'fakultas_diubah_pada';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fakultas_kode',
        'fakultas_kode_dikti',
        'fakultas_nama_resmi',
        'fakultas_nama_singkat',
        'fakultas_nama_asing',
        'fakultas_nama_asing_singkat',
        'fakultas_alamat',
        'fakultas_telepon',
        'fakultas_fax',
        'fakultas_email',
        'fakultas_sk',
        'fakultas_dibuat_pegawai_id',
        'fakultas_diubah_pegawai_id',
    ];
}
