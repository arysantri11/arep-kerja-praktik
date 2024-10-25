<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunPemilihan extends Model
{
    use HasFactory;

    // hanya id yang tidak boleh di isi user
    protected $guarded = ['id'];

    // table yg digunakan
    protected $table = 'tahun_pemilihan';

    // Table Relationship
    // belongsTo = jika table hanya mengambil satu data dari table lain
    public function lembaga_legislatif()
    {
        return $this->belongsTo(LembagaLegislatif::class, 'lembaga_legislatif_id');
    }
}
