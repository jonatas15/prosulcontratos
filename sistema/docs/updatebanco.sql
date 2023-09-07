updatebanco.sql

-- MySQL Workbench Synchronization
-- Generated: 2023-09-07 10:24
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Jonatas

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

ALTER TABLE `prosulcontratos`.`licenciamento` 
DROP FOREIGN KEY `fk_licenciamento_contrato1`;

ALTER TABLE `prosulcontratos`.`fase` 
DROP FOREIGN KEY `fk_fase_empreendimento1`;

ALTER TABLE `prosulcontratos`.`empreendimento` 
ADD COLUMN `contrato_id` INT(11) NULL DEFAULT NULL AFTER `oficio_id`,
ADD INDEX `fk_empreendimento_contrato1_idx` (`contrato_id` ASC);
;

ALTER TABLE `prosulcontratos`.`licenciamento` 
CHANGE COLUMN `contrato_id` `contrato_id` INT(11) NULL DEFAULT NULL ;

ALTER TABLE `prosulcontratos`.`fase` 
ADD COLUMN `licenciamento_id` INT(11) NOT NULL AFTER `empreendimento_id`,
CHANGE COLUMN `empreendimento_id` `empreendimento_id` INT(11) NULL DEFAULT NULL ,
ADD INDEX `fk_fase_licenciamento1_idx` (`licenciamento_id` ASC);
;

ALTER TABLE `prosulcontratos`.`empreendimento` 
ADD CONSTRAINT `fk_empreendimento_contrato1`
  FOREIGN KEY (`contrato_id`)
  REFERENCES `prosulcontratos`.`contrato` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `prosulcontratos`.`licenciamento` 
ADD CONSTRAINT `fk_licenciamento_contrato1`
  FOREIGN KEY (`contrato_id`)
  REFERENCES `prosulcontratos`.`contrato` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `prosulcontratos`.`fase` 
ADD CONSTRAINT `fk_fase_empreendimento1`
  FOREIGN KEY (`empreendimento_id`)
  REFERENCES `prosulcontratos`.`empreendimento` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `fk_fase_licenciamento1`
  FOREIGN KEY (`licenciamento_id`)
  REFERENCES `prosulcontratos`.`licenciamento` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
