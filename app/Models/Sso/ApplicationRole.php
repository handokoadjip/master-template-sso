<?php

namespace App\Models\Sso;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationRole extends Model
{
    use HasFactory;
    use \App\Traits\TraitUuid;

    protected $connection = 'sso';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'aplikasi_peran';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'aplikasi_peran_id';

    /**
     * The Timestamps.
     *
     * @var string
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'aplikasi_peran_id',
        'aplikasi_peran_aplikasi_id',
        'aplikasi_peran_nama',
        'aplikasi_peran_tautan',
    ];

    /**
     * Get the category that owns the application.
     */
    public function application()
    {
        return $this->belongsTo(Application::class, 'aplikasi_peran_aplikasi_id', 'aplikasi_id');
    }

    public function applicationUserRoles()
    {
        return $this->belongsToMany(User::class, 'pengguna_aplikasi_peran', 'pengguna_aplikasi_peran_aplikasi_peran_id', 'pengguna_aplikasi_peran_pengguna_id');
    }
}
