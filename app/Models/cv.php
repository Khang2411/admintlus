<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cv extends Model
{
    use HasFactory;
    protected $fillable =
    [
        "surname",
        "name",
        "gender",
        "phone",
        "region",
        "aspiration",
        "slug_pdf",
        "vnp_id",
        "cccd",
        "school_name",
        "birthday"
    ];
}
