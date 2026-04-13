# Arquitectura

## Decision principal
- Estrategia frontend elegida: `Laravel Blade + componentes Blade + Alpine.js`.
- Motivo: la UI observada es mayormente server-driven, con interacciones ligeras, formularios y estados simples; esta combinacion maximiza fidelidad visual, reduce complejidad y acelera mantenimiento.

## Enfoque de monolito modular
- Los modulos viven en `app/Modulos`.
- Cada modulo concentra sus `Http/Controllers`, `Http/Requests`, `Actions`, `Services`, `Models`, `Events`, `Listeners` y `Policies` cuando aplica.
- Flujo estandar: `Route -> Controller -> FormRequest -> Action/Service -> Model/DB -> Event/Listener -> Redirect/View`.

## Reglas aplicadas
- Controladores delgados.
- Validacion en Form Requests.
- Logica de negocio en acciones o servicios.
- Eventos y listeners para efectos secundarios:
  - `CotizacionEnviada` -> registro de actividad.
  - `CitaConfirmada` -> registro de actividad y creacion de orden de trabajo.
- Rate limiting configurado por flujo en `AppServiceProvider`.

## Modulos implementados
- `Portal`: inicio y contenido visual general.
- `Vehiculos`: alta y listado de vehiculos del usuario.
- `Servicios`: catalogo cliente y fuentes para cotizacion.
- `Cotizaciones`: construccion y persistencia de cotizaciones.
- `Citas`: disponibilidad y agenda.
- `OrdenesTrabajo`: seguimiento de ordenes generadas.
- `Fidelidad`: resumen, niveles, insignias e historial.
- `Compartido`: enums de dominio.

## Por que esta arquitectura reduce riesgo futuro
- La logica de negocio no queda distribuida en vistas ni controladores.
- Los cambios de flujo se concentran en acciones y servicios por modulo.
- Los efectos secundarios no rompen el flujo principal porque salen via eventos/listeners.
- Los modelos y relaciones siguen limites de dominio claros, evitando dependencias circulares.

## Dependencias entre modulos
- `Vehiculos` depende de `User`.
- `Cotizaciones` depende de `Vehiculos` y `Servicios`.
- `Citas` depende de `Vehiculos`.
- `OrdenesTrabajo` depende de `Citas` y `Vehiculos`.
- `Fidelidad` depende de `User` y opcionalmente de eventos de negocio futuros.

## Decisiones de simplicidad
- No se introdujeron repositorios porque Eloquent cubre el acceso actual sin complejidad innecesaria.
- No se usaron triggers; la orquestacion del dominio se resuelve en aplicacion y migraciones con restricciones.
