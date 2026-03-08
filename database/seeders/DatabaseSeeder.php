<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Feature;
use App\Models\Horario;
use App\Models\Ruta;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin user ──
        Admin::create([
            'name'     => 'Administrador FECOSA',
            'email'    => 'admin@terminalfecosa.com',
            'password' => Hash::make('fecosa2025'),
        ]);

        // ── Rutas (from real SQL) ──
        $rutas = [
            ['id'=>1,  'nombre'=>'CANOAS - GUADALUPE',              'anden'=>1,  'slug'=>'canoas-guadalupe'],
            ['id'=>2,  'nombre'=>'PROVIDENCIA - CALLE FLORY',       'anden'=>2,  'slug'=>'providencia-calle-flory'],
            ['id'=>3,  'nombre'=>'SABANILLA',                       'anden'=>3,  'slug'=>'sabanilla'],
            ['id'=>4,  'nombre'=>'JAULARES',                        'anden'=>4,  'slug'=>'jaulares'],
            ['id'=>5,  'nombre'=>'RODEO - CALLE VARGAS',            'anden'=>5,  'slug'=>'rodeo-calle-vargas'],
            ['id'=>6,  'nombre'=>'TAMBOR',                          'anden'=>6,  'slug'=>'tambor'],
            ['id'=>7,  'nombre'=>'TACACORI',                        'anden'=>7,  'slug'=>'tacacori'],
            ['id'=>8,  'nombre'=>'CARRILLOS BAJOS',                 'anden'=>8,  'slug'=>'carrillos-bajos'],
            ['id'=>9,  'nombre'=>'NARANJO',                         'anden'=>9,  'slug'=>'naranjo'],
            ['id'=>10, 'nombre'=>'GRECIA - LA ARGENTINA',           'anden'=>10, 'slug'=>'grecia-la-argentina'],
            ['id'=>12, 'nombre'=>'CARRIZAL',                        'anden'=>12, 'slug'=>'carrizal'],
            ['id'=>13, 'nombre'=>'LA GARITA - TURRUCARES',          'anden'=>13, 'slug'=>'la-garita-turrucares'],
            ['id'=>14, 'nombre'=>'DULCE NOMBRE',                    'anden'=>14, 'slug'=>'dulce-nombre'],
            ['id'=>15, 'nombre'=>'CACAO',                           'anden'=>15, 'slug'=>'cacao'],
            ['id'=>16, 'nombre'=>'CARRILLOS - CHILAMATE',           'anden'=>16, 'slug'=>'carrillos-chilamate'],
            ['id'=>17, 'nombre'=>'POAS',                            'anden'=>17, 'slug'=>'poas'],
            ['id'=>18, 'nombre'=>'BARRIO SAN JOSE - URBA MIRASOL',  'anden'=>18, 'slug'=>'barrio-san-jose'],
            ['id'=>19, 'nombre'=>'ATENAS',                          'anden'=>19, 'slug'=>'atenas'],
            ['id'=>22, 'nombre'=>'SEGURO - BRASILIA',               'anden'=>22, 'slug'=>'seguro-brasilia'],
            ['id'=>23, 'nombre'=>'INVU - GIRALDA',                  'anden'=>23, 'slug'=>'invu-giralda'],
            ['id'=>24, 'nombre'=>'INVU - TARGUASES',                'anden'=>24, 'slug'=>'invu-targuases'],
            ['id'=>25, 'nombre'=>'SANTA BARBARA',                   'anden'=>25, 'slug'=>'santa-barbara'],
            ['id'=>26, 'nombre'=>'CLAUDIA - ROSALES',               'anden'=>26, 'slug'=>'claudia-rosales'],
            ['id'=>27, 'nombre'=>'TUETAL NORTE',                    'anden'=>27, 'slug'=>'tuetal-norte'],
            ['id'=>28, 'nombre'=>'TUETAL SUR',                      'anden'=>28, 'slug'=>'tuetal-sur'],
            ['id'=>29, 'nombre'=>'PUEBLO NUEVO - BARRIO SAN JOSÉ',  'anden'=>29, 'slug'=>'pueblo-nuevo-barrio-san-jose'],
            ['id'=>30, 'nombre'=>'OLIVOS - EL BOSQUE',              'anden'=>30, 'slug'=>'olivos-el-bosque'],
            ['id'=>31, 'nombre'=>'COYOL - SIQUIARES',               'anden'=>31, 'slug'=>'coyol-siquiares'],
            ['id'=>33, 'nombre'=>'PLYWOOD',                         'anden'=>33, 'slug'=>'plywood'],
            ['id'=>34, 'nombre'=>'MONTECILLOS',                     'anden'=>34, 'slug'=>'montecillos'],
            ['id'=>35, 'nombre'=>'URBANO - LA LUCHA',               'anden'=>35, 'slug'=>'urbano-la-lucha'],
            ['id'=>36, 'nombre'=>'GUACIMA ABAJO - LAS VUELTAS',     'anden'=>36, 'slug'=>'guacima-abajo-las-vueltas'],
            ['id'=>37, 'nombre'=>'GUACIMA ARRIBA - RINCÓN HERRERA', 'anden'=>37, 'slug'=>'guacima-arriba-rincon-herrera'],
            ['id'=>38, 'nombre'=>'MONSERRAT - PRADERA',             'anden'=>38, 'slug'=>'monserrat-pradera'],
            ['id'=>39, 'nombre'=>'BARRIO SAN JOSE - SANTA LUCÍA',   'anden'=>18, 'slug'=>'barrio-sanjose-santa-lucia'],
            ['id'=>40, 'nombre'=>'BARRIO SAN JOSE - SANTA RITA',    'anden'=>18, 'slug'=>'barrio-sanjose-santa-rita'],
        ];

        foreach ($rutas as $r) {
            Ruta::create([
                'nombreRuta' => $r['nombre'],
                'anden'      => $r['anden'],
                'slug'       => $r['slug'],
                'activa'     => true,
            ]);
        }

        // ── Horarios (from real SQL, mapped by slug) ──
        $idMap = Ruta::pluck('id', 'slug')->toArray();

        $horarios = [
            // CACAO (slug: cacao) — fue idRuta 15
            ['slug'=>'cacao', 'horas'=>'4:45, 5:10, 5:30, 5:50, 6:20, 6:45, 7:10, 7:30, 8:00, 8:30, 9:00, 9:20, 9:40, 9:55, 10:15, 10:30, 10:50, 11:20, 11:40, 12:00, 12:20, 12:40, 13:00, 13:30, 13:55, 14:20, 14:40, 14:55, 15:20, 15:40, 16:00, 16:20, 16:40, 17:00, 17:20, 17:45, 18:00, 18:20, 18:45, 19:05, 19:30, 20:00, 20:30, 21:00, 21:30, 22:05, 22:45', 'dia'=>'6'],
            ['slug'=>'cacao', 'horas'=>'04:45, 05:00, 05:10, 05:25, 05:40, 05:50, 06:10, 06:20, 06:40, 06:50, 07:00, 07:20, 07:40, 07:55, 08:30, 09:00, 09:30, 10:00, 10:20, 10:50, 11:20, 11:50, 12:20, 12:50, 13:20, 13:50, 14:20, 14:50, 15:10, 15:30, 15:45, 16:00, 16:20, 16:40, 16:55, 17:15, 17:30, 18:00, 18:15, 18:30, 18:45, 19:00, 19:20, 19:40, 20:00, 20:30, 21:00, 21:30, 22:05, 22:25, 22:45', 'dia'=>'1,2,3,4,5'],
            // BARRIO SAN JOSE URBA MIRASOL (idRuta 18)
            ['slug'=>'barrio-san-jose', 'horas'=>'04:50, 05:05, 05:20, 05:36, 05:52, 06:10, 06:30, 06:50, 07:10, 07:30, 07:55, 08:25, 08:55, 09:25, 09:55, 10:25, 10:55, 11:25, 11:55, 12:25, 12:55, 13:25, 13:55, 14:25, 14:55, 15:25, 15:55, 16:15, 16:40, 17:05, 17:30, 17:55, 18:20, 18:40, 19:05, 19:30, 20:00, 20:30, 21:00, 21:30, 22:10, 22:45', 'dia'=>'1,2,3,4,5,6'],
            ['slug'=>'barrio-san-jose', 'horas'=>'05:00, 05:30, 06:00, 06:30, 07:00, 07:30, 08:00, 08:30, 09:00, 09:30, 10:00, 10:30, 11:00, 11:30, 12:00, 12:30, 13:00, 13:30, 14:00, 14:30, 15:00, 15:30, 16:00, 16:30, 17:00, 17:30, 18:00, 18:30, 19:00, 19:30, 20:05, 20:45, 21:25, 22:05, 22:45', 'dia'=>'7'],
            // BARRIO SAN JOSE SANTA RITA (idRuta 40)
            ['slug'=>'barrio-sanjose-santa-rita', 'horas'=>'04:45, 05:00, 05:15, 05:28, 05:44, 06:00, 06:20, 06:40, 07:00, 07:20, 07:40, 08:10, 08:40, 09:10, 09:40, 10:10, 10:40, 11:10, 11:40, 12:10, 12:40, 13:10, 13:40, 14:10, 14:40, 15:10, 15:40, 16:05, 16:25, 16:50, 17:15, 17:40, 18:05, 18:30, 18:50, 19:15, 19:45, 20:15, 20:45, 21:15, 21:50, 22:35', 'dia'=>'1,2,3,4,5,6'],
            ['slug'=>'barrio-sanjose-santa-rita', 'horas'=>'04:45, 05:15, 05:45, 06:15, 06:45, 07:15, 07:45, 08:15, 08:45, 09:15, 09:45, 10:15, 10:45, 11:15, 11:45, 12:15, 12:45, 13:15, 13:45, 14:15, 14:45, 15:15, 15:45, 16:15, 16:45, 17:15, 17:45, 18:15, 18:45, 19:15, 19:45, 20:25, 21:05, 21:45, 22:35', 'dia'=>'7'],
            // BARRIO SAN JOSE SANTA LUCIA (idRuta 39)
            ['slug'=>'barrio-sanjose-santa-lucia', 'horas'=>'05:40, 06:35, 07:35, 08:25, 09:55, 11:25, 12:55, 14:25, 15:55, 17:05, 18:20, 19:30, 20:30, 21:30', 'dia'=>'1,2,3,4,5,6'],
            ['slug'=>'barrio-sanjose-santa-lucia', 'horas'=>'05:30, 07:00, 08:30, 10:00, 11:30, 13:00, 14:30, 16:00, 17:30, 19:00, 20:05, 21:25', 'dia'=>'7'],
            // CARRIZAL (idRuta 12)
            ['slug'=>'carrizal', 'horas'=>'04:30, 04:55, 05:20, 05:35, 06:05, 06:25, 06:45, 07:00, 07:20, 07:40, 10:00, 10:30, 11:00, 11:30, 12:00, 12:30, 13:00, 13:30, 14:00, 14:20, 14:40, 15:00, 15:20, 15:40, 16:00, 16:20, 16:40, 17:00, 17:30, 17:45, 18:00, 18:30, 18:45, 19:00, 19:20, 19:40, 22:00, 22:20, 22:40', 'dia'=>'1,2,3,4,5,6,7'],
            // CANOAS - GUADALUPE (idRuta 1)
            ['slug'=>'canoas-guadalupe', 'horas'=>'04:35, 04:45, 04:55, 05:05, 05:15, 05:25, 05:35, 05:45, 05:55, 06:05, 06:15, 06:25, 06:35, 06:45, 06:55, 07:05, 07:15, 07:25, 07:35, 07:45, 07:55, 08:00, 08:15, 08:30, 08:45, 09:00, 09:15, 09:30, 09:45, 10:00, 10:15, 10:30, 10:45, 11:00, 11:15, 11:45, 12:00, 12:15, 12:30, 12:45, 13:00, 13:15, 13:30, 13:45, 14:00, 14:15, 14:30, 14:45, 15:00, 15:15, 15:25, 16:05, 16:15, 16:25, 16:35, 16:45, 16:55, 17:05, 17:15, 17:25, 18:05, 18:15, 18:25, 18:35, 18:45, 18:55, 19:05, 19:15, 19:25, 19:35, 19:45, 20:00, 20:15, 20:30, 20:45, 21:00, 21:15, 21:30, 21:45, 22:00, 22:15, 22:30', 'dia'=>'1,2,3,4,5,6,7'],
            // ATENAS (idRuta 19)
            ['slug'=>'atenas', 'horas'=>'05:50, 07:00, 08:00, 10:00, 11:00, 12:00, 13:00, 14:00, 15:00, 16:00, 17:00, 17:30, 18:30, 19:30, 21:00, 22:30', 'dia'=>'1,2,3,4,5'],
            ['slug'=>'atenas', 'horas'=>'07:00, 09:00, 10:00, 11:00, 12:00, 13:00, 14:00, 15:00, 16:00, 17:00, 19:00, 22:30', 'dia'=>'6'],
            ['slug'=>'atenas', 'horas'=>'09:00, 11:00, 12:00, 13:00, 15:00, 17:00, 19:00, 22:30', 'dia'=>'7'],
            // CARRILLOS BAJOS (idRuta 8)
            ['slug'=>'carrillos-bajos', 'horas'=>'05:15, 06:00, 07:00, 08:00, 09:00, 11:00, 13:00, 15:00, 16:00, 16:30, 17:00, 17:30, 18:00, 18:30, 19:00, 20:00, 21:00, 22:00', 'dia'=>'1,2,3,4,5'],
            ['slug'=>'carrillos-bajos', 'horas'=>'05:10, 06:00, 07:00, 09:00, 11:00, 15:00, 17:00', 'dia'=>'6'],
            ['slug'=>'carrillos-bajos', 'horas'=>'07:00, 09:00, 11:00, 17:00, 21:00', 'dia'=>'7'],
        ];

        foreach ($horarios as $h) {
            $rutaId = Ruta::where('slug', $h['slug'])->value('id');
            if ($rutaId) {
                Horario::create([
                    'ruta_id'               => $rutaId,
                    'horarioSalidaTerminal' => $h['horas'],
                    'dia'                   => $h['dia'],
                    'activo'                => true,
                ]);
            }
        }

        // ── Features Terminal ──
        $features = [
            ['nombre'=>'Locales Comerciales',  'icono'=>'fa-solid fa-store',         'descripcion'=>'Variedad de locales comerciales para tus compras y necesidades.', 'orden'=>1],
            ['nombre'=>'Paradas Techadas',     'icono'=>'fa-solid fa-umbrella',       'descripcion'=>'Espera cómodamente bajo techo sin importar el clima.', 'orden'=>2],
            ['nombre'=>'Señalización',         'icono'=>'fa-solid fa-signs-post',     'descripcion'=>'Señalización clara para orientarte fácilmente en la terminal.', 'orden'=>3],
            ['nombre'=>'Servicios Sanitarios', 'icono'=>'fa-solid fa-restroom',       'descripcion'=>'Servicios sanitarios limpios disponibles para todos.', 'orden'=>4],
            ['nombre'=>'Amplios Espacios',     'icono'=>'fa-solid fa-arrows-left-right','descripcion'=>'Espacios amplios para moverte con comodidad.', 'orden'=>5],
            ['nombre'=>'Seguridad',            'icono'=>'fa-solid fa-shield-halved',  'descripcion'=>'Personal de seguridad y cámaras para tu tranquilidad.', 'orden'=>6],
            ['nombre'=>'Zonas Verdes',         'icono'=>'fa-solid fa-tree',           'descripcion'=>'Áreas verdes para un ambiente agradable.', 'orden'=>7],
            ['nombre'=>'Muchas Comodidades',   'icono'=>'fa-solid fa-star',           'descripcion'=>'Todo lo que necesitas en un solo lugar.', 'orden'=>8],
        ];

        foreach ($features as $f) {
            Feature::create(array_merge($f, ['activo' => true]));
        }

        $this->command->info('✅  Base de datos poblada con datos reales de Terminal FECOSA.');
    }
}
