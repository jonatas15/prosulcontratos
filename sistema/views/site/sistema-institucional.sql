-- MySQL Workbench Synchronization
-- Generated: 2023-06-09 11:15
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Jonatas

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE TABLE `contrato` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(45) NOT NULL,
  `datacadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dataupdate` datetime DEFAULT NULL,
  `icone` text,
  `obs` text,
  `lote` text,
  `objeto` varchar(250) DEFAULT NULL,
  `num_edital` varchar(250) DEFAULT NULL,
  `empresa_executora` varchar(200) DEFAULT NULL,
  `data_assinatura` date DEFAULT NULL,
  `data_final` date DEFAULT NULL,
  `saldo_prazo` decimal(10,2) DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL,
  `valor_faturado` decimal(10,2) DEFAULT NULL,
  `saldo_contrato` decimal(10,2) DEFAULT NULL,
  `valor_empenhado` decimal(10,2) DEFAULT NULL,
  `saldo_empenho` decimal(10,2) DEFAULT NULL,
  `data_base` date DEFAULT NULL,
  `vigencia` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `prosulcontratos`.`placemark` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `arquivo` TEXT NOT NULL,
  `contrato_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_placemark_contrato_idx` (`contrato_id` ASC) VISIBLE,
  CONSTRAINT `fk_placemark_contrato`
    FOREIGN KEY (`contrato_id`)
    REFERENCES `prosulcontratos`.`contrato` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;

CREATE TABLE IF NOT EXISTS `prosulcontratos`.`oficio` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `contrato_id` INT(11) NOT NULL,
  `emprrendimento_id` INT(11) NULL DEFAULT NULL,
  `tipo` VARCHAR(45) NULL DEFAULT NULL,
  `emprrendimento_desc` VARCHAR(150) NULL DEFAULT NULL,
  `datacadastro` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data` DATE NULL DEFAULT NULL,
  `fluxo` VARCHAR(200) NULL DEFAULT NULL,
  `emissor` VARCHAR(200) NULL DEFAULT NULL,
  `receptor` VARCHAR(200) NULL DEFAULT NULL,
  `num_processo` VARCHAR(200) NULL DEFAULT NULL,
  `num_protocolo` VARCHAR(200) NULL DEFAULT NULL,
  `Num_sei` VARCHAR(200) NULL DEFAULT NULL,
  `assunto` TEXT NULL DEFAULT NULL,
  `diretorio` VARCHAR(100) NULL DEFAULT NULL,
  `status` VARCHAR(30) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_oficio_emprrendimento1_idx` (`emprrendimento_id` ASC),
  INDEX `fk_oficio_contrato1_idx` (`contrato_id` ASC),
  CONSTRAINT `fk_oficio_emprrendimento1`
    FOREIGN KEY (`emprrendimento_id`)
    REFERENCES `prosulcontratos`.`empreendimento` (`id`)
    ON DELETE SET NULL
    ON UPDATE SET NULL,
  CONSTRAINT `fk_oficio_contrato1`
    FOREIGN KEY (`contrato_id`)
    REFERENCES `prosulcontratos`.`contrato` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;

CREATE TABLE IF NOT EXISTS `prosulcontratos`.`empreendimento` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `prazo` INT(11) NULL DEFAULT NULL,
  `datacadastro` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dataupdate` DATETIME NULL DEFAULT NULL,
  `status` VARCHAR(25) NULL DEFAULT NULL,
  `uf` VARCHAR(3) NULL DEFAULT NULL,
  `segmento` VARCHAR(100) NULL DEFAULT NULL,
  `extensao_km` DECIMAL(10,2) NULL DEFAULT NULL,
  `tipo_obra` VARCHAR(250) NULL DEFAULT NULL,
  `municipios_interceptados` TEXT NULL DEFAULT NULL,
  `orgao_licenciador` VARCHAR(200) NULL DEFAULT NULL,
  `ordensdeservico_id` INT(11) NULL DEFAULT NULL,
  `oficio_id` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_emprrendimento_ordensdeservico1_idx` (`ordensdeservico_id` ASC),
  INDEX `fk_emprrendimento_oficio1_idx` (`oficio_id` ASC),
  CONSTRAINT `fk_emprrendimento_ordensdeservico1`
    FOREIGN KEY (`ordensdeservico_id`)
    REFERENCES `prosulcontratos`.`ordensdeservico` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_emprrendimento_oficio1`
    FOREIGN KEY (`oficio_id`)
    REFERENCES `prosulcontratos`.`oficio` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;

CREATE TABLE IF NOT EXISTS `prosulcontratos`.`ordensdeservico` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `oficio_id` INT(11) NULL DEFAULT NULL,
  `fase` ENUM('Manifestação de Interesse em Análise', 'OS Emitida', 'OS em Andamento', 'OS Paralisada', 'OS Finalisada') NULL DEFAULT NULL,
  `plano` ENUM('Plano de Trabalho Solicitado', 'Plano de Trabalho em Andamento', 'Plano de Trabalho  Entregue DNIT', 'Plano de Trabalho em Análise DNIT', 'Plano de Trabalho em Revisão', 'Plano de Trabalho Aprovado DNIT') NULL DEFAULT NULL,
  `contrato_id` INT(11) NOT NULL,
  `datacadastro` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_ordensdeservico_oficio1_idx` (`oficio_id` ASC),
  INDEX `fk_ordensdeservico_contrato1_idx` (`contrato_id` ASC),
  CONSTRAINT `fk_ordensdeservico_oficio1`
    FOREIGN KEY (`oficio_id`)
    REFERENCES `prosulcontratos`.`oficio` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_ordensdeservico_contrato1`
    FOREIGN KEY (`contrato_id`)
    REFERENCES `prosulcontratos`.`contrato` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;

CREATE TABLE IF NOT EXISTS `prosulcontratos`.`licenciamento` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `ordensdeservico_id` INT(11) NULL DEFAULT NULL,
  `numero` VARCHAR(45) NULL DEFAULT NULL,
  `datacadastro` VARCHAR(45) NOT NULL DEFAULT 'CURRENT_TIMESTAMP',
  `dataedicao` VARCHAR(45) NULL DEFAULT NULL,
  `data_validade` VARCHAR(45) NULL DEFAULT NULL,
  `data_renovacao` VARCHAR(45) NULL DEFAULT NULL,
  `descricao` TEXT NULL DEFAULT NULL,
  `empreendimento_id` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_licenciamento_ordensdeservico1_idx` (`ordensdeservico_id` ASC),
  INDEX `fk_licenciamento_empreendimento1_idx` (`empreendimento_id` ASC),
  CONSTRAINT `fk_licenciamento_ordensdeservico1`
    FOREIGN KEY (`ordensdeservico_id`)
    REFERENCES `prosulcontratos`.`ordensdeservico` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_licenciamento_empreendimento1`
    FOREIGN KEY (`empreendimento_id`)
    REFERENCES `prosulcontratos`.`empreendimento` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;

CREATE TABLE IF NOT EXISTS `prosulcontratos`.`produto` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `ordensdeservico_id` INT(11) NULL DEFAULT NULL,
  `numero` VARCHAR(45) NULL DEFAULT NULL,
  `datacadastro` VARCHAR(45) NOT NULL DEFAULT 'CURRENT_TIMESTAMP',
  `dataedicao` VARCHAR(45) NULL DEFAULT NULL,
  `data_validade` VARCHAR(45) NULL DEFAULT NULL,
  `data_renovacao` VARCHAR(45) NULL DEFAULT NULL,
  `descricao` TEXT NULL DEFAULT NULL,
  `empreendimento_id` INT(11) NULL DEFAULT NULL,
  `fase` VARCHAR(150) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_licenciamento_ordensdeservico1_idx` (`ordensdeservico_id` ASC),
  INDEX `fk_produto_empreendimento1_idx` (`empreendimento_id` ASC),
  CONSTRAINT `fk_licenciamento_ordensdeservico10`
    FOREIGN KEY (`ordensdeservico_id`)
    REFERENCES `prosulcontratos`.`ordensdeservico` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_produto_empreendimento1`
    FOREIGN KEY (`empreendimento_id`)
    REFERENCES `prosulcontratos`.`empreendimento` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;

CREATE TABLE IF NOT EXISTS `prosulcontratos`.`arquivo` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `tipo` ENUM('imagem', 'logo', 'video', 'documento', 'planilia', 'outros') NOT NULL,
  `datacadastro` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `src` TEXT NOT NULL,
  `contrato_id` INT(11) NULL DEFAULT NULL,
  `oficio_id` INT(11) NULL DEFAULT NULL,
  `ordensdeservico_id` INT(11) NULL DEFAULT NULL,
  `empreendimento_id` INT(11) NULL DEFAULT NULL,
  `produto_id` INT(11) NULL DEFAULT NULL,
  `licenciamento_id` INT(11) NULL DEFAULT NULL,
  `pasta` VARCHAR(45) NULL DEFAULT NULL,
  `ref` VARCHAR(250) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_arquivo_contrato1_idx` (`contrato_id` ASC) VISIBLE,
  INDEX `fk_arquivo_oficio1_idx` (`oficio_id` ASC) VISIBLE,
  INDEX `fk_arquivo_ordensdeservico1_idx` (`ordensdeservico_id` ASC),
  INDEX `fk_arquivo_empreendimento1_idx` (`empreendimento_id` ASC),
  INDEX `fk_arquivo_produto1_idx` (`produto_id` ASC) VISIBLE,
  INDEX `fk_arquivo_licenciamento1_idx` (`licenciamento_id` ASC),
  CONSTRAINT `fk_arquivo_contrato1`
    FOREIGN KEY (`contrato_id`)
    REFERENCES `prosulcontratos`.`contrato` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_arquivo_oficio1`
    FOREIGN KEY (`oficio_id`)
    REFERENCES `prosulcontratos`.`oficio` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_arquivo_ordensdeservico1`
    FOREIGN KEY (`ordensdeservico_id`)
    REFERENCES `prosulcontratos`.`ordensdeservico` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_arquivo_empreendimento1`
    FOREIGN KEY (`empreendimento_id`)
    REFERENCES `prosulcontratos`.`empreendimento` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_arquivo_produto1`
    FOREIGN KEY (`produto_id`)
    REFERENCES `prosulcontratos`.`produto` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_arquivo_licenciamento1`
    FOREIGN KEY (`licenciamento_id`)
    REFERENCES `prosulcontratos`.`licenciamento` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
