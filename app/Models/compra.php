<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class compra extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pedidos()
    {
        return $this->hasMany(pedido::class);
    }
}
