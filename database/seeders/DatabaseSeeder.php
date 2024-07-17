<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Producto;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '123pass789'
        ]);

        User::factory()->create([
            'name' => 'Gustavo Martinez',
            'email' => 'gustavomartinez@egmail.com',
            'admin' => 1,
            'password' => 'gustavo123'
        ]);

        $productos = [
            ['nombre' => 'Papa', 'unidad_medida' => 'kg'],
            ['nombre' => 'Lechuga', 'unidad_medida' => 'kg'],
            ['nombre' => 'Tomate', 'unidad_medida' => 'kg'],
            ['nombre' => 'Zanahoria', 'unidad_medida' => 'kg'],
            ['nombre' => 'Pimiento Rojo', 'unidad_medida' => 'kg'],
            ['nombre' => 'Pimiento Verde', 'unidad_medida' => 'kg'],
            ['nombre' => 'Pimiento Amarillo', 'unidad_medida' => 'kg'],
            ['nombre' => 'Cebolla', 'unidad_medida' => 'kg'],
            ['nombre' => 'Ajo', 'unidad_medida' => 'unidad'],
            ['nombre' => 'Calabacín (zucchini)', 'unidad_medida' => 'kg'],
            ['nombre' => 'Berenjena', 'unidad_medida' => 'kg'],
            ['nombre' => 'Repollo', 'unidad_medida' => 'kg'],
            ['nombre' => 'Puerro', 'unidad_medida' => 'kg'],
            ['nombre' => 'Rabanito', 'unidad_medida' => 'kg'],
            ['nombre' => 'Acelga', 'unidad_medida' => 'paquete'],
            ['nombre' => 'Batata', 'unidad_medida' => 'kg'],
            ['nombre' => 'Remolacha', 'unidad_medida' => 'kg'],
            ['nombre' => 'Choclo (maíz)', 'unidad_medida' => 'unidad'],
            ['nombre' => 'Rúcula', 'unidad_medida' => 'kg']
        ];

        foreach($productos as $producto) {
            Producto::factory()->create(array_merge($producto, ['user_id' => 1]));
        }
    }
}
