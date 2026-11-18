ALTER TABLE nuevo_usu
  ADD COLUMN email_verificado    TINYINT(1) NOT NULL DEFAULT 0,
  ADD COLUMN token_verificacion  CHAR(64)   NULL,
  ADD COLUMN token_expira        DATETIME   NULL,
  ADD INDEX idx_token_verificacion (token_verificacion);

UPDATE nuevo_usu SET email_verificado = 1;
