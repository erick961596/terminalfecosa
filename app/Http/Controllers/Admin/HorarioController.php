<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Horario;
use App\Models\Ruta;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index()
    {
        $rutas    = Ruta::orderBy('nombreRuta')->get();
        $horarios = Horario::with('ruta')->orderBy('ruta_id')->get();
        return view('admin.horarios.index', compact('rutas', 'horarios'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ruta_id'               => 'required|exists:rutas,id',
            'horarioSalidaTerminal' => 'required|string',
            'dia'                   => 'required|string',
            'activo'                => 'boolean',
        ]);

        // Normalize hours string
        $data['horarioSalidaTerminal'] = $this->normalizeHoras($data['horarioSalidaTerminal']);

        $horario = Horario::create($data);
        $horario->load('ruta');

        return response()->json(['success' => true, 'horario' => $horario, 'message' => 'Horario creado correctamente.']);
    }

    public function update(Request $request, Horario $horario)
    {
        $data = $request->validate([
            'ruta_id'               => 'required|exists:rutas,id',
            'horarioSalidaTerminal' => 'required|string',
            'dia'                   => 'required|string',
            'activo'                => 'boolean',
        ]);

        $data['horarioSalidaTerminal'] = $this->normalizeHoras($data['horarioSalidaTerminal']);

        $horario->update($data);
        $horario->load('ruta');

        return response()->json(['success' => true, 'horario' => $horario, 'message' => 'Horario actualizado.']);
    }

    public function destroy(Horario $horario)
    {
        $horario->delete();
        return response()->json(['success' => true, 'message' => 'Horario eliminado.']);
    }

    /**
     * Import horarios from CSV file.
     * Expected CSV columns: ruta_id (or slug), horas, dias
     * Example: 15,"4:45, 5:10, 5:30","1,2,3,4,5"
     */
    public function importCsv(Request $request)
    {
        $request->validate(['csv_file' => 'required|file|mimes:csv,txt|max:2048']);

        $file    = $request->file('csv_file');
        $handle  = fopen($file->getPathname(), 'r');
        $header  = fgetcsv($handle); // skip header row
        $imported = 0;
        $errors  = [];
        $row = 1;

        while (($data = fgetcsv($handle)) !== false) {
            $row++;
            if (count($data) < 3) {
                $errors[] = "Fila {$row}: formato inválido (se esperan 3 columnas).";
                continue;
            }

            [$rutaRef, $horas, $dias] = array_map('trim', $data);

            // Find ruta by id or slug
            $ruta = is_numeric($rutaRef)
                ? Ruta::find($rutaRef)
                : Ruta::where('slug', $rutaRef)->first();

            if (!$ruta) {
                $errors[] = "Fila {$row}: ruta '{$rutaRef}' no encontrada.";
                continue;
            }

            Horario::create([
                'ruta_id'               => $ruta->id,
                'horarioSalidaTerminal' => $this->normalizeHoras($horas),
                'dia'                   => trim($dias),
                'activo'                => true,
            ]);

            $imported++;
        }

        fclose($handle);

        return response()->json([
            'success'  => true,
            'imported' => $imported,
            'errors'   => $errors,
            'message'  => "{$imported} horarios importados" . (count($errors) ? " con " . count($errors) . " errores." : " correctamente."),
        ]);
    }

    private function normalizeHoras(string $horas): string
    {
        $arr = array_map('trim', explode(',', $horas));
        $arr = array_filter($arr);
        // Pad single digit hours: 4:30 → 04:30
        $arr = array_map(function ($h) {
            if (strlen($h) === 4 && $h[1] === ':') return '0' . $h;
            return $h;
        }, $arr);
        return implode(', ', $arr);
    }
}
