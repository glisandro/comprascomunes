<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pedido extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->user_id = auth()->id();
        });

        /*static::saving(function ($model) {
            $model->campo1 = strtoupper($model->campo1);
        });*/
    }

    //protected $with = ['pedidos_detalles.producto'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function compra(): BelongsTo
    {
        return $this->belongsTo(Compra::class);
    }

    public function pedidodetalle()
    {
        return $this->hasMany(PedidoDetalle::class);
    }
}
