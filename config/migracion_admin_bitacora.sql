-- config/migracion_admin_bitacora.sql
-- Ejecutar UNA SOLA VEZ en phpMyAdmin (base de datos: sisvo)

-- 1) Bitácora de auditoría (solo se inserta y se consulta; nunca se edita desde la app)
CREATE TABLE IF NOT EXISTS bitacora (
    id             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fecha          TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CI_usu         VARCHAR(10)     NULL,          -- quién hizo la acción (sin FK: el registro sobrevive si se borra el usuario)
    nombre         VARCHAR(200)    NULL,
    rol            VARCHAR(20)     NULL,
    accion         VARCHAR(50)     NOT NULL,      -- login_ok, login_fallido, logout, editar, eliminar, exportar_bitacora...
    entidad        VARCHAR(50)     NULL,          -- usuarios, becas, convocatorias, instituciones...
    entidad_id     VARCHAR(50)     NULL,
    datos_antes    LONGTEXT        NULL,          -- JSON con los campos antes del cambio
    datos_despues  LONGTEXT        NULL,          -- JSON con los campos después del cambio
    detalle        VARCHAR(500)    NULL,
    ip             VARCHAR(45)     NULL,
    user_agent     VARCHAR(255)    NULL,
    INDEX idx_bit_fecha   (fecha),
    INDEX idx_bit_usuario (CI_usu),
    INDEX idx_bit_accion  (accion),
    INDEX idx_bit_entidad (entidad, entidad_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 2) Permite desactivar cuentas sin borrarlas
ALTER TABLE nuevo_usu
    ADD COLUMN activo TINYINT(1) NOT NULL DEFAULT 1;

-- 3) Para promover una cuenta YA existente a administrador (cambia el correo):
-- UPDATE nuevo_usu SET rol = 'admin', email_verificado = 1, activo = 1 WHERE correo = 'tu_correo@ejemplo.com';
-- (o crea una cuenta nueva con:  php config/crear_admin.php)
