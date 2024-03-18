<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Mesin extends Model
{
    use HasFactory;
    protected $table = 'mesins';
    protected $fillable = [
        'id',
        'nama_mesin',
        'no_mesin', 'merk', 'type',
        'mfg_date', 'acq_date', 'age', 'preventive_date',
        'foto', 'sparepart', 'status'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d | H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d | H:i:s');
    }

    public function formFPP()
    {
        return $this->belongsTo(FormFPP::class, 'id_fpp', 'id_fpp');
    }

    public function preventives()
    {
        return $this->hasMany(Preventive::class);
    }

    public function detailPreventives()
    {
        return $this->hasMany(DetailPreventive::class, 'id_mesin', 'id');
    }

    public function getStatusBackgroundColorAttribute()
    {
        $status = strtolower($this->attributes['status']);

        switch ($status) {
            case '0':
                return 'green'; // Mengubah warna menjadi 'green' untuk status 0 (Open)
            case '1':
                return 'blue'; // Mengubah warna menjadi 'orange' untuk status 1 (On Progress)
            default:
                return 'transparent'; // Mengembalikan 'transparent' untuk nilai lain
        }
    }
    public function ubahText()
    {
        $status = $this->attributes['status'];

        switch ($status) {
            case '0':
                return 'Open';
            case '1':
                return 'Finish';
            default:
                return 'Unknown';
        }
    }
}
