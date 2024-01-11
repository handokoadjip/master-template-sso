<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
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
    protected $table = 'prodi';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'prodi_id';

    const CREATED_AT = 'prodi_dibuat_pada';
    const UPDATED_AT = 'prodi_diubah_pada';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'prodi_fakultas_id',
        'prodi_jurusan_id',
        'prodi_jenjang_id',
        'prodi_kode',
        'prodi_kode_dikti',
        'prodi_label_nim',
        'prodi_nama_resmi',
        'prodi_nama_singkat',
        'prodi_nama_asing',
        'prodi_nama_asing_singkat',
        'prodi_sks_lulus',
        'prodi_alamat',
        'prodi_telepon',
        'prodi_fax',
        'prodi_email',
        'prodi_website',
        'prodi_sk',
        'prodi_tanggal_sk',
        'prodi_tanggal_berakhir_sk',
        'prodi_tanggal_berdiri',
        'prodi_status_aktif',
        'prodi_gelar_kelulusan',
        'prodi_gelar_kelulusan_singkat',
        'prodi_gelar_kelulusan_asing',
        'prodi_dibuat_pegawai_id',
        'prodi_diubah_pegawai_id',
    ];

    /**
     * Get the biodata associated with the student.
     */
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'prodi_fakultas_id');
    }
}
