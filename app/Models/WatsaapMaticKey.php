<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WatsaapMaticKey extends Model
{
    use HasFactory;
    protected $table = 'watsaap_matic_keys';
    protected $fillable = ['users_id', 'name', 'api_secret', 'whatsapp_server_id'];
}
