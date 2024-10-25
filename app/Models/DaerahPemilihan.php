<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaerahPemilihan extends Model
{
    use HasFactory;

    // hanya id yang tidak boleh di isi user
    protected $guarded = ['id'];

    // table yg digunakan
    protected $table = 'daerah_pemilihan';

    // Table Relationship
    // belongsTo = jika table hanya mengambil satu data dari table lain
    public function tahun_pemilihan()
    {
        return $this->belongsTo(TahunPemilihan::class, 'tahun_pemilihan_id');
    }
}
