<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function book()
    {
        return $this->belongsTo(Book::class,'buku_id');
    }

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
