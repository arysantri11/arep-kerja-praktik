<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartaiPolitik extends Model
{
    use HasFactory;

    // hanya id yang tidak boleh di isi user
    protected $guarded = ['id'];

    // table yg digunakan
    protected $table = 'partai_politik';

    // Table Relationship
    // belongsTo = jika table hanya mengambil satu data dari table lain
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function caleg()
    {
        return $this->hasMany(Caleg::class, 'partai_id');
    }
}
