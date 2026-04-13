<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InicioTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_pagina_de_inicio_responde_correctamente(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Tecnicentro de Confianza en Honduras');
    }
}
