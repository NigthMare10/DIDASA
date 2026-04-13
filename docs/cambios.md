# Cambios

## 2026-04-13
- Se inicializo el proyecto Laravel dentro de `Desktop/Didasa` con PHP portable y Composer local para evitar dependencias globales ausentes.
- Se implemento autenticacion Blade con Breeze y layout visual del portal.
- Se construyo arquitectura modular en `app/Modulos` para portal, vehiculos, servicios, cotizaciones, citas, ordenes y fidelidad.
- Se crearon migraciones, seeders, relaciones y SQL documentado.
- Se implementaron eventos/listeners para cotizacion y cita.
- Se documentaron decisiones de seguridad, despliegue, librerias y criterios de aceptacion.
- Desviacion aceptada: SQLite queda habilitado para pruebas locales; MySQL sigue siendo el motor objetivo documentado.
- Fase de correccion visual completada: ajuste de layout global, navbar, footer, tipografia, hover, cards, responsive y eliminacion de overflow horizontal.
- Se corrigieron `Mis Cotizaciones` y `Mis Citas` para que funcionen como listados visuales principales con sus formularios integrados debajo, manteniendo backend existente.
- Se refino `Mis Vehiculos` y se agrego `Carnet de Salud` con vista detalle y exportacion PDF.
- Se valido visualmente la ausencia de overflow horizontal con Playwright en `inicio`, `cotizar`, `agendar`, `mis-vehiculos`, `carnet`, `servicios`, `mis-ordenes` y `fidelidad` en desktop amplio, laptop, tablet y movil.
- Fase fina de comportamiento/paridad: `Cotizar` vuelve a ser flujo de nueva cotizacion y `Agendar` vuelve a ser flujo de nueva cita; `Mis Cotizaciones` y `Mis Citas` quedan en rutas separadas accesibles desde perfil.
- Se implemento disponibilidad reactiva por mes en agenda usando endpoint JSON y Alpine para evitar refresh completo al seleccionar fecha.
- Se reforzo navbar sticky con translucidez, blur, sombra y estados activos correctos por ruta.
- Se ajustaron proporciones laterales en `cotizar`, `agendar` y `fidelidad` para acercarlas mas a la referencia.
- Se revalido overflow horizontal y comportamiento de calendario sin refresh con Playwright sobre escritorio amplio, laptop, tablet y movil.
- Correccion final puntual: la navbar paso de `sticky` a comportamiento fijo real con compensacion de espaciado superior global para que acompañe el scroll en todas las vistas.
- Se afino la barra superior con translucidez, blur y sombra visible al desplazarse, ademas de ajuste fino de altura, paddings, logo, avatar y separacion entre items.
- Se restauro la franja azul superior en `cotizar` y `agendar`, manteniendo los flujos actuales y sin tocar arquitectura.
- Se reforzo el comportamiento sticky real de `Resumen` en cotizar y `Resumen de Cita` en agendar con offset compatible con la navbar fija.
- Se validaron los 8 puntos pedidos, incluyendo ausencia de overflow horizontal, navbar fija en rutas principales y calendario de agenda sin refresh completo.
- Endurecimiento final backend: se agrego `RegisterRequest` con reglas mas estrictas para nombre, correo, contrasena y confirmacion.
- Se reforzaron validaciones backend en vehiculos, cotizaciones, citas y perfil, incluyendo sanitizacion basica, formatos y ownership del vehiculo seleccionado.
- Se aplico ownership check probado para carnet de salud, eliminacion de vehiculos, cambio de estado de cotizaciones e historiales filtrados por usuario.
- Se agrego rate limiting para registro y recuperacion de contrasena; login mantiene su limitacion propia y los endpoints sensibles de negocio conservan throttle dedicado.
- Se limpio el proyecto de artefactos internos no funcionales: se eliminaron `.opencode/skills`, el script interno de validacion visual y el log auxiliar del servidor; ademas se agregaron exclusiones especificas al `.gitignore`.
- Se agrego franja azul superior a `Mis Vehículos` para mantener consistencia visual con el portal.
