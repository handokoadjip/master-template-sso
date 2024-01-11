<?php

namespace App\Models\Sso;

use App\Models\Sso\Group;
use App\Models\Backoffice\Group as GroupBackoffice;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeBiodata;
use App\Models\Student\Student;
use App\Models\Student\StudentBiodata;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use \App\Traits\TraitUuid;

    protected $connection = 'sso';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengguna';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'pengguna_id';

    const CREATED_AT = 'pengguna_dibuat_pada';
    const UPDATED_AT = 'pengguna_diubah_pada';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pengguna_nama',
        'pengguna_email',
        'pengguna_email_verifikasi_pada',
        'pengguna_password',
        'pengguna_remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'pengguna_password',
        'pengguna_remeber_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'pengguna_email_verifikasi_pada' => 'datetime',
    ];

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->pengguna_password;
    }

    /**
     * Get the User associated with the user.
     */
    public function employee()
    {
        return $this->hasOne(Employee::class, 'pegawai_sso_id', 'pengguna_id');
    }

    /**
     * Get the User associated with the user.
     */
    public function employeeBiodata()
    {
        return $this->hasManyThrough(EmployeeBiodata::class, Employee::class, 'pegawai_sso_id', 'pegawai_biodata_pegawai_id', 'pengguna_id', 'pegawai_id');
    }

    /**
     * Get the User associated with the user.
     */
    public function student()
    {
        return $this->hasOne(Student::class, 'mahasiswa_sso_id', 'pengguna_id');
    }

    /**
     * Get the User associated with the user.
     */
    public function studentBiodata()
    {
        return $this->hasManyThrough(StudentBiodata::class, Student::class, 'mahasiswa_sso_id', 'mahasiswa_biodata_mahasiswa_id', 'pengguna_id', 'mahasiswa_id');
    }

    /**
     * The groups that belong to the user.
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'pengguna_grup', 'pengguna_grup_pengguna_id', 'pengguna_grup_grup_id');
    }

    /**
     * The groups that belong to the user.
     */
    public function groupsBackoffice()
    {
        return $this->belongsToMany(GroupBackoffice::class, 'pengguna_grup', 'pengguna_grup_pengguna_id', 'pengguna_grup_grup_id');
    }

    public function applicationUserRoles()
    {
        return $this->belongsToMany(ApplicationRole::class, 'pengguna_aplikasi_peran', 'pengguna_aplikasi_peran_pengguna_id', 'pengguna_aplikasi_peran_aplikasi_peran_id');
    }
}
