@switch($estado)
    @case('vehiculo-registrado')
        Vehiculo registrado correctamente.
        @break
    @case('vehiculo-eliminado')
        Vehiculo eliminado correctamente.
        @break
    @case('cotizacion-enviada')
        Cotizacion enviada correctamente. Referencia: {{ session('referenciaCotizacion') }}.
        @break
    @case('cotizacion-aprobada')
        Cotizacion aprobada.
        @break
    @case('cotizacion-rechazada')
        Cotizacion rechazada.
        @break
    @case('cita-confirmada')
        Cita confirmada correctamente. Ya puedes dar seguimiento desde Mis Ordenes.
        @break
    @default
        Operacion realizada correctamente.
@endswitch
