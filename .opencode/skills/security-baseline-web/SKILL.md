---
nombre: security-baseline-web
descripcion: Garantiza la linea base de seguridad de la aplicacion web Laravel DIDASA.
---

# security-baseline-web

## Instrucciones
- Validar toda entrada de usuario.
- Mantener CSRF, sesiones seguras, escape de salida y autorizacion sobre recursos privados.
- Revisar secretos y errores antes de cerrar cualquier cambio relevante.

## Checklist accionable
- Form Requests o validacion equivalente presentes.
- Rutas privadas protegidas con `auth` y policies cuando corresponda.
- Formularios con token CSRF.
- Salida Blade escapada por defecto.
- Rate limiting en flujos sensibles.
- Secretos fuera del repositorio.

## Archivos y sesiones
- Si se agregan archivos, validar mime, tamano y almacenamiento privado.
- Usar cookies seguras en produccion y revisar tiempo de sesion.

## Senales de error o desviacion
- Precios o ids confiados al cliente sin recalculo del backend.
- Exposicion de excepciones sensibles al usuario.
- Recursos de un usuario accesibles por otro via id directo.
