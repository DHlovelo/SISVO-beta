-- config/migracion_verificacion_correo.sql
-- Ejecutar UNA SOLA VEZ en phpMyAdmin (base de datos: sisvo)

ALTER TABLE nuevo_usu
  ADD COLUMN email_verificado    TINYINT(1) NOT NULL DEFAULT 0,
  ADD COLUMN token_verificacion  CHAR(64)   NULL,
  ADD COLUMN token_expira        DATETIME   NULL,
  ADD INDEX idx_token_verificacion (token_verificacion);

-- Las cuentas que YA existen se consideran verificadas
-- (si no, nadie que ya esté registrado podría volver a entrar)
UPDATE nuevo_usu SET email_verificado = 1;
