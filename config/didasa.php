<?php

return [
    'categoriasInicio' => [
        ['nombre' => 'Motor', 'icono' => 'llave'],
        ['nombre' => 'Frenos', 'icono' => 'freno'],
        ['nombre' => 'Suspension', 'icono' => 'suspension'],
        ['nombre' => 'Electrico', 'icono' => 'rayo'],
        ['nombre' => 'A/C', 'icono' => 'clima'],
        ['nombre' => 'Alineacion', 'icono' => 'alineacion'],
        ['nombre' => 'Diagnostico', 'icono' => 'diagnostico'],
    ],
    'beneficiosInicio' => [
        [
            'icono' => 'vehiculo',
            'titulo' => 'Gestion de Vehiculos',
            'descripcion' => 'Registra multiples vehiculos con su carnet de salud digital completo.',
        ],
        [
            'icono' => 'documento',
            'titulo' => 'Cotizacion Inteligente',
            'descripcion' => 'Cotiza servicios con desglose detallado y aprobacion digital.',
        ],
        [
            'icono' => 'calendario',
            'titulo' => 'Agendamiento Online',
            'descripcion' => 'Agenda tu cita con calendario visual de disponibilidad.',
        ],
        [
            'icono' => 'ojo',
            'titulo' => 'Tracking en Tiempo Real',
            'descripcion' => 'Sigue cada etapa de la reparacion de tu vehiculo.',
        ],
        [
            'icono' => 'escudo',
            'titulo' => 'Inspeccion Digital (DVI)',
            'descripcion' => 'Fotos y videos del estado real de tu vehiculo.',
        ],
        [
            'icono' => 'trofeo',
            'titulo' => 'Programa de Fidelidad',
            'descripcion' => 'Acumula puntos y desbloquea niveles con beneficios exclusivos.',
        ],
    ],
    'pasosInicio' => [
        ['numero' => '01', 'icono' => 'documento', 'titulo' => 'Cotiza', 'descripcion' => 'Selecciona los servicios que necesitas y recibe un desglose detallado.'],
        ['numero' => '02', 'icono' => 'calendario', 'titulo' => 'Agenda', 'descripcion' => 'Elige la fecha y hora que mejor te convenga para tu cita.'],
        ['numero' => '03', 'icono' => 'portapapeles', 'titulo' => 'Seguimiento', 'descripcion' => 'Monitorea en tiempo real cada etapa de la reparacion.'],
        ['numero' => '04', 'icono' => 'check-circle', 'titulo' => 'Recoge', 'descripcion' => 'Tu vehiculo listo con inspeccion digital y garantia.'],
    ],
    'horarios' => [
        'diasLaborales' => [1, 2, 3, 4, 5, 6],
        'horas' => [
            '07:00', '07:30', '08:00', '08:30', '09:00', '09:30', '10:00',
            '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30',
            '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00',
        ],
    ],
    'gananciasPuntos' => [
        ['concepto' => 'Completar un servicio', 'puntos' => 100],
        ['concepto' => 'Dejar una resena', 'puntos' => 50],
        ['concepto' => 'Referir un amigo', 'puntos' => 200],
        ['concepto' => 'Servicio de paquete', 'puntos' => 150],
    ],
    'contacto' => [
        'telefono' => '+504 2222-3333',
        'direccion' => 'San Pedro Sula, Honduras',
        'horario' => 'Lun-Sab 7:00am - 6:00pm',
    ],
];
