<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeBiodata extends Model
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
    protected $table = 'pegawai_biodata';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'pegawai_biodata_id';

    const CREATED_AT = 'pegawai_biodata_dibuat_pada';
    const UPDATED_AT = 'pegawai_biodata_diubah_pada';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pegawai_biodata_pegawai_id',
        'pegawai_biodata_agama_id',
        'pegawai_biodata_statusnikah_id',
        'pegawai_biodata_nik',
        'pegawai_biodata_berkas_ktp',
        'pegawai_biodata_nama',
        'pegawai_biodata_nama_ibu',
        'pegawai_biodata_jenis_kelamin',
        'pegawai_biodata_kewarganegaraan',
        'pegawai_biodata_negara_kode',
        'pegawai_biodata_tempat_lahir',
        'pegawai_biodata_tanggal_lahir',
        'pegawai_biodata_lahir_propinsi_id',
        'pegawai_biodata_alamat',
        'pegawai_biodata_nama_jalan',
        'pegawai_biodata_kode_pos',
        'pegawai_biodata_rt',
        'pegawai_biodata_rw',
        'pegawai_biodata_propinsi_id',
        'pegawai_biodata_kota_id',
        'pegawai_biodata_kecamatan_id',
        'pegawai_biodata_kelurahan_id',
        'pegawai_biodata_dusun',
        'pegawai_biodata_nomor_telepon',
        'pegawai_biodata_nomor_telepon_kantor',
        'pegawai_biodata_nomor_telepon_rumah',
        'pegawai_biodata_deskripsi_diri',
        'pegawai_biodata_golongan_darah',
    ];
}
