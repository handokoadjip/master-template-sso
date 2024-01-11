<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Religion extends Model
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
    protected $table = 'agama';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'agama_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'agama_id',
        'agama_nama',
    ];
}
