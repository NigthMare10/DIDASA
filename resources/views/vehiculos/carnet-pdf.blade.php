<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Carnet de Salud - {{ $vehiculo->placa }}</title>
        <style>
            body { font-family: DejaVu Sans, sans-serif; color: #182235; font-size: 12px; }
            .panel { background: #1b2538; color: #fff; padding: 24px; border-radius: 18px; }
            .titulo { font-size: 28px; font-weight: 700; margin: 0 0 8px; }
            .subtitulo { font-size: 14px; color: #d4d9e2; }
            .seccion { margin-top: 28px; }
            .seccion h2 { font-size: 16px; margin-bottom: 12px; }
            .item { border: 1px solid #d8dee7; border-radius: 14px; padding: 12px; margin-bottom: 10px; }
            .muted { color: #5f697a; }
        </style>
    </head>
    <body>
        <div class="panel">
            <div class="titulo">{{ $vehiculo->marca }} {{ $vehiculo->modelo }} {{ $vehiculo->anio }}</div>
            <div class="subtitulo">Placa: {{ $vehiculo->placa }} | Carnet de Salud Digital</div>
        </div>

        <div class="seccion">
            <h2>Resumen</h2>
            <p><strong>Estado general:</strong> {{ $estadoGeneral }}</p>
            <p><strong>Proxima revision:</strong> {{ $proximaRevision }}</p>
            <p><strong>Kilometraje actual:</strong> {{ number_format($vehiculo->kilometraje) }} km</p>
        </div>

        <div class="seccion">
            <h2>Historial de Servicios</h2>
            @forelse ($historialServicios as $servicio)
                <div class="item">
                    <div><strong>{{ $servicio['titulo'] }}</strong></div>
                    <div class="muted">{{ $servicio['descripcion'] }}</div>
                    <div class="muted">{{ $servicio['fecha'] }} - {{ str_replace('_', ' ', $servicio['estado']) }}</div>
                </div>
            @empty
                <div class="item muted">Sin historial de servicios aun.</div>
            @endforelse
        </div>

        <div class="seccion">
            <h2>Recordatorios</h2>
            @forelse ($recordatorios as $recordatorio)
                <div class="item muted">{{ $recordatorio }}</div>
            @empty
                <div class="item muted">Sin recordatorios pendientes.</div>
            @endforelse
        </div>
    </body>
</html>
