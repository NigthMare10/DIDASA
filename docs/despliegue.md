# Despliegue

## Requisitos recomendados
- PHP 8.3+
- Composer 2.9+
- Node 24+
- MySQL 8+
- Nginx o Apache con HTTPS

## Pasos base
1. Copiar `.env.example` a `.env`.
2. Configurar `APP_URL`, claves y credenciales MySQL.
3. Ejecutar `composer install --no-dev --optimize-autoloader`.
4. Ejecutar `php artisan key:generate`.
5. Ejecutar `php artisan migrate --seed --force`.
6. Ejecutar `npm install && npm run build`.
7. Configurar cola y scheduler si se agregan tareas asincronas futuras.

## Seguridad de despliegue
- `APP_DEBUG=false`
- HTTPS obligatorio
- Rotacion de logs
- Copias de seguridad de BD y storage
- Variables de entorno fuera del repositorio
