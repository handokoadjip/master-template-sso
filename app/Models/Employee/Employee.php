<?php

namespace App\Models\Employee;

use App\Models\Backoffice\User;
use App\Models\Sso\EmployeeBiodata;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    use \App\Traits\TraitUuid;

    protected $connection = 'master_pegawai';
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pegawai';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'pegawai_id';

    const CREATED_AT = 'pegawai_dibuat_pada';
    const UPDATED_AT = 'pegawai_diubah_pada';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pegawai_sdm_id',
        'pegawai_sso_id',
        'pegawai_status_pegawai_id',
        'pegawai_ikatan_kerja_id',
        'pegawai_unit_kerja_id',
        'pegawai_status_aktif_id',
        'pegawai_nip',
        'pegawai_nidn',
        'pegawai_foto',
        'pegawai_gelar_depan',
        'pegawai_gelar_belakang',
        'pegawai_email',
        'pegawai_email_pribadi',
        'pegawai_nomor_kk',
        'pegawai_berkas_kk',
        'pegawai_nomor_npwp',
        'pegawai_nama_npwp',
        'pegawai_berkas_npwp',
        'pegawai_nomor_bpjs_kesehatan',
        'pegawai_berkas_bpjs_kesehatan',
        'pegawai_berkas_bpjs_ketenagakerjaan',
        'pegawai_nomor_bpjs_ketenagakerjaan',
        'pegawai_nomor_kartu_taspen',
        'pegawai_berkas_kartu_taspen',
        'pegawai_berkas_kartu_pegawai',
        'pegawai_tanggal_masuk',
        'pegawai_tanggal_pra_jabatan',
        'pegawai_catatan',
        'pegawai_TMT',
        'pegawai_TMT_jabatan_fungsional',
        'pegawai_nil_kum',
        'pegawai_simulasi',
        'pegawai_instansi_asal',
        'pegawai_sk_tempat_lahir',
    ];

    /**
     * Get the User associated with the user.
     */
    public function User()
    {
        return $this->hasOne(User::class, 'pengguna_id', 'pegawai_sso_id');
    }

    /**
     * Get the EmployeeBiodata associated with the user.
     */
    public function EmployeeBiodata()
    {
        return $this->hasOne(EmployeeBiodata::class, 'pegawai_id', 'pegawai_biodata_pegawai_id');
    }
}
