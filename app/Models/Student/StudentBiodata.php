<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentBiodata extends Model
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
    protected $table = 'mahasiswa_biodata';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'mahasiswa_biodata_id';

    const CREATED_AT = 'mahasiswa_biodata_dibuat_pada';
    const UPDATED_AT = 'mahasiswa_biodata_diubah_pada';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mahasiswa_biodata_mahasiswa_id',
        'mahasiswa_biodata_agama_id',
        'mahasiswa_biodata_status_nikah_id',
        'mahasiswa_biodata_status_rumah_id',
        'mahasiswa_biodata_transportasi_id',
        'mahasiswa_biodata_jenis_tinggal_id',
        'mahasiswa_biodata_nik',
        'mahasiswa_biodata_nama',
        'mahasiswa_biodata_jenis_kelamin',
        'mahasiswa_biodata_kewarganegaraan',
        'mahasiswa_biodata_kode_negara',
        'mahasiswa_biodata_tanggal_lahir',
        'mahasiswa_biodata_lahir_kota_id',
        'mahasiswa_biodata_alamat',
        'mahasiswa_biodata_kode_pos',
        'mahasiswa_biodata_nama_jalan',
        'mahasiswa_biodata_rt',
        'mahasiswa_biodata_rw',
        'mahasiswa_biodata_propinsi_id',
        'mahasiswa_biodata_kota_id',
        'mahasiswa_biodata_kecamatan_id',
        'mahasiswa_biodata_kelurahan_id',
        'mahasiswa_biodata_dusun',
        'mahasiswa_biodata_nomor_telepon',
        'mahasiswa_biodata_nomor_telepon_rumah',
        'mahasiswa_biodata_golongan_darah',
        'mahasiswa_biodata_hobi',
        'mahasiswa_biodata_kebutuhan_khusus',
    ];

    /**
     * Get the biodata associated with the student.
     */
    public function religion()
    {
        return $this->belongsTo(Religion::class, 'mahasiswa_biodata_agama_id');
    }
}
