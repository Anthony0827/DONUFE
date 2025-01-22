<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_the_application_view_loads_correctly(): void
    {
        $response = $this->get('/ruta-de-tu-vista');

        $response->assertStatus(200);
        $response->assertSee('Candidatos'); // Verifica que el texto "Candidatos" esté presente en la vista
    }

    public function test_rutas_principales(): void
    {
        $rutas = [
            '/',
            '/candidatos/inicio',
            '/usuarios/registro',
            '/usuarios/login',
            // '/candidatos/home', // Ruta que requiere autenticación
            // '/tablero', // Ruta que requiere autenticación
            '/dashboard'
        ];

        foreach ($rutas as $ruta) {
            $response = $this->get($ruta);
            $response->assertStatus(200);
        }
    }
}
