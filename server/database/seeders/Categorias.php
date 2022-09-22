<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Categorias extends Seeder
{
	static $categorias = [
        'Cliente',
        'Proveedor',
        'Funcionario Interno'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	foreach (self::$categorias as $key => $value) {
	        DB::table('categorias')->insert([
	            'categoria' => $value
	        ]);
    	}
    }
}
