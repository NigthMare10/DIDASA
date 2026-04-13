# Modulos

## Portal
- Responsabilidad: inicio, contenido institucional y navegacion principal.
- Entrada principal: `InicioController`.

## Vehiculos
- Responsabilidad: registrar y consultar vehiculos del usuario autenticado.
- Componentes: `RegistrarVehiculoRequest`, `RegistrarVehiculoAction`, `VehiculoController`, `VehiculoPolicy`.

## Servicios
- Responsabilidad: exponer catalogo visible y proveer datos de servicios/paquetes para cotizacion.
- Componentes: `CatalogoServicioController`, modelos `CategoriaServicio`, `Servicio`, `Paquete`.

## Cotizaciones
- Responsabilidad: validar, construir y persistir cotizaciones con items mixtos.
- Componentes: `CrearCotizacionRequest`, `CrearCotizacionAction`, `CotizacionController`, evento `CotizacionEnviada`.

## Citas
- Responsabilidad: disponibilidad, calendario y confirmacion de citas.
- Componentes: `DisponibilidadCitasService`, `CrearCitaRequest`, `CrearCitaAction`, `CitaController`, evento `CitaConfirmada`.

## OrdenesTrabajo
- Responsabilidad: seguimiento del flujo operativo visible al cliente.
- Componentes: `OrdenTrabajoController`, `OrdenTrabajo`, `OrdenTrabajoEvento`, `OrdenTrabajoPolicy`.

## Fidelidad
- Responsabilidad: resumen de puntos, nivel actual, insignias y reglas visibles de acumulacion.
- Componentes: `ResumenFidelidadService`, `FidelidadController`, modelos de fidelidad.

## Compartido
- Responsabilidad: enums de estados y tipos compartidos entre modulos.
