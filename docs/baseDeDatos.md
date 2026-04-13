# Base de Datos

## Motor objetivo
- Objetivo productivo: MySQL 8.x.
- Soporte local actual: SQLite para ejecucion de pruebas y validacion automatica en este entorno, documentado por ausencia de servidor MySQL local.

## Tablas principales
- `users`
- `vehiculos`
- `categorias_servicio`
- `servicios`
- `paquetes`
- `paquete_servicio`
- `cotizaciones`
- `cotizacion_items`
- `citas`
- `ordenes_trabajo`
- `orden_trabajo_eventos`
- `niveles_fidelidad`
- `movimientos_puntos`
- `insignias`
- `usuario_insignia`
- `activity_log`

## Relaciones clave
- `vehiculos.user_id -> users.id`
- `servicios.categoria_servicio_id -> categorias_servicio.id`
- `paquete_servicio.paquete_id -> paquetes.id`
- `paquete_servicio.servicio_id -> servicios.id`
- `cotizaciones.user_id -> users.id`
- `cotizaciones.vehiculo_id -> vehiculos.id`
- `cotizacion_items.cotizacion_id -> cotizaciones.id`
- `cotizacion_items.servicio_id -> servicios.id`
- `cotizacion_items.paquete_id -> paquetes.id`
- `citas.user_id -> users.id`
- `citas.vehiculo_id -> vehiculos.id`
- `ordenes_trabajo.user_id -> users.id`
- `ordenes_trabajo.vehiculo_id -> vehiculos.id`
- `ordenes_trabajo.cita_id -> citas.id`
- `orden_trabajo_eventos.orden_trabajo_id -> ordenes_trabajo.id`
- `movimientos_puntos.user_id -> users.id`
- `usuario_insignia.user_id -> users.id`
- `usuario_insignia.insignia_id -> insignias.id`

## Indices y restricciones
- Unicos: `vehiculos.placa`, `vehiculos.vin`, `cotizaciones.numero_cotizacion`, `ordenes_trabajo.numero_orden`, `categorias_servicio.slug`, `servicios.slug`, `paquetes.slug`.
- Indices compuestos: disponibilidad de citas, estados de cotizaciones y visibilidad de catalogo.
- Restricciones: claves foraneas con `cascadeOnDelete` o `nullOnDelete` segun el caso.

## Triggers
- No se usaron triggers.
- Razon: la creacion de ordenes desde citas y el registro de actividad se resuelven en la capa de aplicacion con eventos/listeners, lo que mejora trazabilidad, pruebas y mantenibilidad.

## SQL final
- El SQL detallado equivalente a las migraciones esta documentado en `database/sql/esquemaCompleto.md`.
