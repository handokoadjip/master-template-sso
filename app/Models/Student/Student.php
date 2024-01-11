<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
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
    protected $table = 'mahasiswa';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'mahasiswa_id';

    const CREATED_AT = 'mahasiswa_dibuat_pada';
    const UPDATED_AT = 'mahasiswa_diubah_pada';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mahasiswa_feeder_id',
        'mahasiswa_sso_id',
        'mahasiswa_jalur_masuk_id',
        'mahasiswa_fakultas_id',
        'mahasiswa_prodi_id',
        'mahasiswa_konsentrasi_id',
        'mahasiswa_status_aktif_id',
        'mahasiswa_nim',
        'mahasiswa_nim_lama',
        'mahasiswa_nisn',
        'mahasiswa_nomor_tes',
        'mahasiswa_nomor_akses',
        'mahasiswa_foto',
        'mahasiswa_email',
        'mahasiswa_email_pribadi',
        'mahasiswa_nomor_npwp',
        'mahasiswa_nama_npwp',
        'mahasiswa_berkas_npwp',
        'mahasiswa_tanggal_terdaftar',
        'mahasiswa_angkatan',
        'mahasiswa_biaya_kuliah',
        'mahasiswa_pengubah_pegawai_id',
        'mahasiswa_dibuat_pada',
        'mahasiswa_diubah_pada',
        'mahasiswa_diubah_pegawai_pada',
    ];

    /**
     * Get the biodata associated with the student.
     */
    public function studentBiodata()
    {
        return $this->hasOne(StudentBiodata::class, 'mahasiswa_biodata_mahasiswa_id', 'mahasiswa_id');
    }

    /**
     * Get the biodata associated with the student.
     */
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'mahasiswa_fakultas_id');
    }

    /**
     * Get the biodata associated with the student.
     */
    public function major()
    {
        return $this->belongsTo(Major::class, 'mahasiswa_prodi_id');
    }
}
