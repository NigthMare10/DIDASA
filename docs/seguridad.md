# Seguridad

## Controles implementados
- Validacion de entradas con Form Requests en flujos de vehiculos, cotizaciones y citas.
- Proteccion CSRF nativa de Laravel.
- Escape de salida por Blade por defecto.
- Consultas mediante Eloquent y Query Builder, sin concatenacion SQL.
- Sesiones en base de datos.
- Rate limiting por flujo para vehiculos, cotizaciones y citas.
- Control de acceso por autenticacion para modulos privados.
- Policies para recursos sensibles de vehiculos y ordenes.
- Registro de acciones sensibles con `spatie/laravel-activitylog`.

## Riesgos controlados
- Manipulacion de precios en cotizacion: el backend recalcula precios reales para servicios y paquetes.
- Acceso horizontal: controlado con filtro por usuario autenticado y policies.
- Exposicion de secretos: `.env.example` sin secretos; configuracion separada por entorno.

## Recomendaciones de endurecimiento para despliegue
- `APP_DEBUG=false` en produccion.
- Cookies seguras y `SESSION_SECURE_COOKIE=true` en HTTPS.
- Rate limiting adicional en login y password reset si se intensifica trafico.
- Almacenamiento de archivos en disco privado si se agrega DVI.
- Activar monitoreo, backups y rotacion de logs.
