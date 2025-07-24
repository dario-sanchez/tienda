ALTER TABLE `ordenes` 
ADD COLUMN `total_no_iva` FLOAT(45) NULL DEFAULT NULL AFTER `descuento_cantidad`;
---------------------------
ALTER TABLE `ordenes` 
ADD COLUMN `comentarios` TEXT NULL DEFAULT NULL AFTER `descuento_pack`;
