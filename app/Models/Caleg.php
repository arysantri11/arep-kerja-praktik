<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caleg extends Model
{
    use HasFactory;

    // hanya id yang tidak boleh di isi user
    protected $guarded = ['id'];

    // table yg digunakan
    protected $table = 'caleg';

    // Table Relationship
    // belongsTo = jika table hanya mengambil satu data dari table lain
    public function partai_politik()
    {
        return $this->belongsTo(PartaiPolitik::class, 'partai_id');
    }

    public function daerah_pemilihan()
    {
        return $this->belongsTo(DaerahPemilihan::class, 'daerah_pemilihan_id');
    }
}
