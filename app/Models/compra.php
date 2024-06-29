<?php

namespace App\Models;

use App\Enums\Estado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'estado' => Estado::class,
        ];
    }

    public function pedidos()
    {
        return $this->hasMany(pedido::class);
    }
}
