<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Custom extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'judul',
        'subjudul',
        'alamat',
        'no_hp',
        'email',
        'jam_operasional',
        'link_instagram',
        'link_facebook',
        'link_whatsapp',
    ];
}