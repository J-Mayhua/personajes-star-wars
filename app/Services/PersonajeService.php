<?php

namespace App\Services;

use App\Models\Personaje;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class PersonajeService
{
    public function importarDesdeSwapi(int $swapiId): Personaje
    {
        try {
            $response = Http::acceptJson()
                ->timeout(10)
                ->get("https://swapi.py4e.com/api/people/{$swapiId}/");
        } catch (ConnectionException) {
            throw new RuntimeException('No se pudo conectar con SWAPI. Verifica tu conexión e intenta nuevamente.');
        }

        if ($response->notFound()) {
            throw new RuntimeException('El ID indicado no existe en SWAPI.');
        }

        if ($response->failed()) {
            throw new RuntimeException("SWAPI no está disponible (código {$response->status()}).");
        }

        $datos = $this->transformar($response->json());

        return Personaje::create([
            ...$datos,
            'origen_swapi' => true,
            'swapi_id' => $swapiId,
            'planeta_origen' => null,
        ]);
    }

    private function transformar(array $datos): array
    {
        return [
            'nombre' => $datos['name'],
            'altura' => $this->enteroONull($datos['height']),
            'masa' => $this->enteroONull($datos['mass']),
            'color_cabello' => $datos['hair_color'],
            'color_ojos' => $datos['eye_color'],
            'genero' => $this->genero($datos['gender']),
        ];
    }

    private function enteroONull(string $valor): ?int
    {
        $limpio = str_replace(',', '', $valor);

        return is_numeric($limpio) ? (int) $limpio : null;
    }

    private function genero(string $genero): string
    {
        return match ($genero) {
            'male' => 'masculino',
            'female' => 'femenino',
            default => 'n/a',
        };
    }
}
