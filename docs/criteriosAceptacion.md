# Criterios de Aceptacion

## UI
- Navbar, heroes, tarjetas y CTA respetan la referencia.
- Estados vacios implementados en vehiculos, servicios, ordenes e historial.
- Responsive revisado en layout principal y formularios.
- Sin overflow horizontal en escritorio amplio, laptop, tablet ni movil en rutas principales validadas.
- Hover de categorias y cards perceptible pero sutil, sin redisenar la experiencia.
- Footer presente y consistente en todo el portal.
- `Mis Cotizaciones`, `Mis Citas`, `Mis Vehiculos` y `Carnet de Salud` alineados con la referencia funcional y visual disponible.
- Navbar sticky/translucida validada en `/`, `/servicios`, `/cotizar`, `/agendar`, `/fidelidad` y `/mis-vehiculos`.
- `Cotizar` abre nueva cotizacion y `Agendar` abre nueva cita; los historiales quedan fuera de la navbar principal.
- El calendario de agenda actualiza fecha y resumen sin refresh completo.
- Los resúmenes laterales de cita y cotizacion permanecen sticky en desktop sin romper responsive.
- La navbar permanece visible al hacer scroll en `/`, `/servicios`, `/cotizar`, `/agendar`, `/mis-vehiculos`, `/fidelidad`, `/mis-ordenes`, `/mis-cotizaciones`, `/mis-citas` y carnet de salud.
- `Cotizar` y `Agendar` recuperan su franja azul superior con titulo y subtitulo, alineada a la referencia.
- La barra superior conserva blur/transparencia real durante el scroll y no tapa incorrectamente el contenido gracias al espaciado superior compensado.

## Backend
- Flujos funcionales: registrar vehiculo, crear cotizacion, agendar cita, visualizar ordenes y ver fidelidad.
- Controladores delgados y validacion en Form Requests.
- Eventos/listeners funcionando para cotizaciones y citas.

## Base de datos
- Migraciones consistentes y seeders funcionales.
- Relaciones, claves foraneas e indices definidos.
- SQL final documentado.

## Seguridad
- CSRF, validacion, sesiones, rate limiting y acceso autenticado activos.

## Calidad
- Pruebas unitarias y feature para flujos criticos.
- Documentacion base entregada y changelog actualizado.
- Build frontend exitoso y validacion de breakpoints ejecutada con navegador automatizado.
- Validacion automatizada adicional de rutas principales, rutas de historial y ausencia de overflow tras los cambios de navegacion.
