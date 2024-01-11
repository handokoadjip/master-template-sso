<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    use \App\Traits\TraitUuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'log_id';

    const CREATED_AT = 'log_dibuat_pada';
    const UPDATED_AT = 'log_diubah_pada';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'log_pengguna_id',
        'log_subjek',
        'log_tautan',
        'log_metode',
        'log_keterangan_awal',
        'log_keterangan_setelah',
        'log_ip',
        'log_agent',
    ];

    /**
     * Get the user that owns the phone.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'pengguna_id', 'log_pengguna_id');
    }
}
