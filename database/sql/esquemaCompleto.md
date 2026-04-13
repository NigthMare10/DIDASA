# Esquema SQL Completo

## Nota
- Este SQL representa el equivalente MySQL 8.x de las migraciones activas.
- No se usan triggers; la logica de dominio queda en Laravel mediante acciones, transacciones y eventos.

```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE vehiculos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    marca VARCHAR(60) NOT NULL,
    modelo VARCHAR(60) NOT NULL,
    anio SMALLINT UNSIGNED NOT NULL,
    placa VARCHAR(20) NOT NULL UNIQUE,
    vin VARCHAR(40) NULL UNIQUE,
    kilometraje INT UNSIGNED NOT NULL DEFAULT 0,
    color VARCHAR(40) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_vehiculos_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE categorias_servicio (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(80) NOT NULL,
    slug VARCHAR(80) NOT NULL UNIQUE,
    icono VARCHAR(40) NULL,
    descripcion VARCHAR(255) NULL,
    orden SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE servicios (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    categoria_servicio_id BIGINT UNSIGNED NULL,
    nombre VARCHAR(120) NOT NULL,
    slug VARCHAR(120) NOT NULL UNIQUE,
    descripcion TEXT NULL,
    precio_base DECIMAL(10,2) NOT NULL,
    duracion_minutos SMALLINT UNSIGNED NOT NULL DEFAULT 60,
    visible_catalogo TINYINT(1) NOT NULL DEFAULT 0,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_servicios_categoria_activo (categoria_servicio_id, activo),
    INDEX idx_servicios_visible_activo (visible_catalogo, activo),
    CONSTRAINT fk_servicios_categoria FOREIGN KEY (categoria_servicio_id) REFERENCES categorias_servicio(id) ON DELETE SET NULL
);

CREATE TABLE paquetes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120) NOT NULL,
    slug VARCHAR(120) NOT NULL UNIQUE,
    descripcion TEXT NULL,
    precio_base DECIMAL(10,2) NOT NULL,
    visible_catalogo TINYINT(1) NOT NULL DEFAULT 0,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_paquetes_visible_activo (visible_catalogo, activo)
);

CREATE TABLE paquete_servicio (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    paquete_id BIGINT UNSIGNED NOT NULL,
    servicio_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY uq_paquete_servicio (paquete_id, servicio_id),
    CONSTRAINT fk_paquete_servicio_paquete FOREIGN KEY (paquete_id) REFERENCES paquetes(id) ON DELETE CASCADE,
    CONSTRAINT fk_paquete_servicio_servicio FOREIGN KEY (servicio_id) REFERENCES servicios(id) ON DELETE CASCADE
);

CREATE TABLE cotizaciones (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    vehiculo_id BIGINT UNSIGNED NOT NULL,
    numero_cotizacion VARCHAR(30) NOT NULL UNIQUE,
    estado VARCHAR(20) NOT NULL DEFAULT 'enviada',
    subtotal DECIMAL(10,2) NOT NULL,
    impuesto DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    notas TEXT NULL,
    enviada_en TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_cotizaciones_usuario_fecha (user_id, created_at),
    INDEX idx_cotizaciones_vehiculo_estado (vehiculo_id, estado),
    CONSTRAINT fk_cotizaciones_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_cotizaciones_vehiculo FOREIGN KEY (vehiculo_id) REFERENCES vehiculos(id) ON DELETE CASCADE
);

CREATE TABLE cotizacion_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cotizacion_id BIGINT UNSIGNED NOT NULL,
    tipo_item VARCHAR(20) NOT NULL,
    servicio_id BIGINT UNSIGNED NULL,
    paquete_id BIGINT UNSIGNED NULL,
    descripcion VARCHAR(150) NOT NULL,
    cantidad SMALLINT UNSIGNED NOT NULL DEFAULT 1,
    precio_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_cotizacion_items_cotizacion FOREIGN KEY (cotizacion_id) REFERENCES cotizaciones(id) ON DELETE CASCADE,
    CONSTRAINT fk_cotizacion_items_servicio FOREIGN KEY (servicio_id) REFERENCES servicios(id) ON DELETE SET NULL,
    CONSTRAINT fk_cotizacion_items_paquete FOREIGN KEY (paquete_id) REFERENCES paquetes(id) ON DELETE SET NULL
);

CREATE TABLE citas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    vehiculo_id BIGINT UNSIGNED NOT NULL,
    fecha DATE NOT NULL,
    hora VARCHAR(5) NOT NULL,
    estado VARCHAR(20) NOT NULL DEFAULT 'confirmada',
    notas TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY uq_cita_vehiculo_fecha_hora (vehiculo_id, fecha, hora),
    INDEX idx_citas_fecha_hora_estado (fecha, hora, estado),
    CONSTRAINT fk_citas_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_citas_vehiculo FOREIGN KEY (vehiculo_id) REFERENCES vehiculos(id) ON DELETE CASCADE
);

CREATE TABLE ordenes_trabajo (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    vehiculo_id BIGINT UNSIGNED NOT NULL,
    cita_id BIGINT UNSIGNED NULL,
    numero_orden VARCHAR(30) NOT NULL UNIQUE,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT NULL,
    estado VARCHAR(30) NOT NULL DEFAULT 'agendada',
    progreso TINYINT UNSIGNED NOT NULL DEFAULT 0,
    fecha_ingreso DATE NOT NULL,
    fecha_estimada DATE NULL,
    fecha_entrega DATE NULL,
    total_estimado DECIMAL(10,2) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_ordenes_user_estado (user_id, estado),
    CONSTRAINT fk_ordenes_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_ordenes_vehiculo FOREIGN KEY (vehiculo_id) REFERENCES vehiculos(id) ON DELETE CASCADE,
    CONSTRAINT fk_ordenes_cita FOREIGN KEY (cita_id) REFERENCES citas(id) ON DELETE SET NULL
);

CREATE TABLE orden_trabajo_eventos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    orden_trabajo_id BIGINT UNSIGNED NOT NULL,
    titulo VARCHAR(120) NOT NULL,
    descripcion VARCHAR(190) NULL,
    estado_etapa VARCHAR(40) NULL,
    orden SMALLINT UNSIGNED NOT NULL DEFAULT 1,
    completado TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_orden_eventos_orden FOREIGN KEY (orden_trabajo_id) REFERENCES ordenes_trabajo(id) ON DELETE CASCADE
);

CREATE TABLE niveles_fidelidad (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(80) NOT NULL,
    slug VARCHAR(80) NOT NULL UNIQUE,
    puntos_minimos INT UNSIGNED NOT NULL DEFAULT 0,
    descuento_porcentaje TINYINT UNSIGNED NOT NULL DEFAULT 0,
    color VARCHAR(20) NULL,
    icono VARCHAR(40) NULL,
    orden SMALLINT UNSIGNED NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE movimientos_puntos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    tipo VARCHAR(20) NOT NULL,
    descripcion VARCHAR(150) NOT NULL,
    puntos INT NOT NULL,
    saldo_resultante INT NOT NULL DEFAULT 0,
    origen_tipo VARCHAR(60) NULL,
    origen_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_movimientos_user_fecha (user_id, created_at),
    CONSTRAINT fk_movimientos_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE insignias (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(80) NOT NULL,
    descripcion VARCHAR(150) NOT NULL,
    criterio VARCHAR(120) NOT NULL,
    icono VARCHAR(40) NULL,
    orden SMALLINT UNSIGNED NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE usuario_insignia (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    insignia_id BIGINT UNSIGNED NOT NULL,
    obtenida_en TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY uq_usuario_insignia (user_id, insignia_id),
    CONSTRAINT fk_usuario_insignia_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_usuario_insignia_insignia FOREIGN KEY (insignia_id) REFERENCES insignias(id) ON DELETE CASCADE
);
```
