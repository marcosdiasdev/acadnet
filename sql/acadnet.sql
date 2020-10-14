SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `acadnet` DEFAULT CHARACTER SET utf8 ;
USE `acadnet` ;

-- -----------------------------------------------------
-- Table `acadnet`.`usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `acadnet`.`usuario` ;

CREATE  TABLE IF NOT EXISTS `acadnet`.`usuario` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(30) NOT NULL ,
  `sobrenome` VARCHAR(45) NOT NULL ,
  `nascimento` DATE NOT NULL ,
  `genero` INT(1) NOT NULL ,
  `email` VARCHAR(100) NOT NULL ,
  `senha` VARCHAR(16) NOT NULL ,
  `instituicao` VARCHAR(50) NULL ,
  `curso` VARCHAR(50) NULL DEFAULT NULL ,
  `empresa` VARCHAR(50) NULL DEFAULT NULL ,
  `profissao` VARCHAR(50) NULL DEFAULT NULL ,
  `imagem` VARCHAR(100) NULL ,
  `status` VARCHAR(140) NULL DEFAULT NULL ,
  `codigo_redefinicao_senha` VARCHAR(32) NULL ,
  PRIMARY KEY (`id_usuario`) )
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = latin1
ROW_FORMAT = COMPACT;


-- -----------------------------------------------------
-- Table `acadnet`.`amigo_env`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `acadnet`.`amigo_env` ;

CREATE  TABLE IF NOT EXISTS `acadnet`.`amigo_env` (
  `id_amigo_env` INT NOT NULL AUTO_INCREMENT ,
  `id_amigo` INT NOT NULL ,
  `usuario_id_usuario` INT NOT NULL ,
  `estado` TINYINT(1) NOT NULL ,
  PRIMARY KEY (`id_amigo_env`) ,
  INDEX `fk_amigo_env_usuario1_idx` (`usuario_id_usuario` ASC) ,
  INDEX `fk_amigo_env_usuario2_idx` (`id_amigo` ASC) ,
  CONSTRAINT `fk_amigo_env_usuario1`
    FOREIGN KEY (`usuario_id_usuario` )
    REFERENCES `acadnet`.`usuario` (`id_usuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_amigo_env_usuario2`
    FOREIGN KEY (`id_amigo` )
    REFERENCES `acadnet`.`usuario` (`id_usuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `acadnet`.`amigo_rec`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `acadnet`.`amigo_rec` ;

CREATE  TABLE IF NOT EXISTS `acadnet`.`amigo_rec` (
  `id_amigo_rec` INT NOT NULL AUTO_INCREMENT ,
  `id_amigo` INT NOT NULL ,
  `usuario_id_usuario` INT NOT NULL ,
  `estado` TINYINT(1) NOT NULL ,
  PRIMARY KEY (`id_amigo_rec`) ,
  INDEX `fk_amigo_rec_usuario1_idx` (`usuario_id_usuario` ASC) ,
  INDEX `fk_amigo_rec_usuario2_idx` (`id_amigo` ASC) ,
  CONSTRAINT `fk_amigo_rec_usuario1`
    FOREIGN KEY (`usuario_id_usuario` )
    REFERENCES `acadnet`.`usuario` (`id_usuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_amigo_rec_usuario2`
    FOREIGN KEY (`id_amigo` )
    REFERENCES `acadnet`.`usuario` (`id_usuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `acadnet`.`recado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `acadnet`.`recado` ;

CREATE  TABLE IF NOT EXISTS `acadnet`.`recado` (
  `id_recado` INT NOT NULL AUTO_INCREMENT ,
  `usuario_id_usuario` INT NOT NULL ,
  `usuario_id_remetente` INT NOT NULL ,
  `texto_recado` TEXT NOT NULL ,
  `data_recado` DATETIME NOT NULL ,
  PRIMARY KEY (`id_recado`) ,
  INDEX `fk_recado_usuario1_idx` (`usuario_id_usuario` ASC) ,
  INDEX `fk_recado_usuario2_idx` (`usuario_id_remetente` ASC) ,
  CONSTRAINT `fk_recado_usuario1`
    FOREIGN KEY (`usuario_id_usuario` )
    REFERENCES `acadnet`.`usuario` (`id_usuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_recado_usuario2`
    FOREIGN KEY (`usuario_id_remetente` )
    REFERENCES `acadnet`.`usuario` (`id_usuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 12
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `acadnet`.`documento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `acadnet`.`documento` ;

CREATE  TABLE IF NOT EXISTS `acadnet`.`documento` (
  `id_documento` INT NOT NULL AUTO_INCREMENT ,
  `titulo` VARCHAR(50) NOT NULL ,
  `descricao` VARCHAR(100) NOT NULL ,
  `usuario_id_usuario` INT NOT NULL ,
  `data_documento` DATETIME NOT NULL ,
  `caminho` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id_documento`) ,
  INDEX `fk_documento_usuario1_idx` (`usuario_id_usuario` ASC) ,
  CONSTRAINT `fk_documento_usuario1`
    FOREIGN KEY (`usuario_id_usuario` )
    REFERENCES `acadnet`.`usuario` (`id_usuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `acadnet`.`grupo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `acadnet`.`grupo` ;

CREATE  TABLE IF NOT EXISTS `acadnet`.`grupo` (
  `id_grupo` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(45) NOT NULL ,
  `descricao` TEXT NULL ,
  `data_criacao` DATE NOT NULL ,
  `usuario_id_usuario` INT NOT NULL ,
  `imagem` VARCHAR(100) NULL ,
  PRIMARY KEY (`id_grupo`) ,
  INDEX `fk_grupo_usuario1_idx` (`usuario_id_usuario` ASC) ,
  CONSTRAINT `fk_grupo_usuario1`
    FOREIGN KEY (`usuario_id_usuario` )
    REFERENCES `acadnet`.`usuario` (`id_usuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `acadnet`.`grupo_has_usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `acadnet`.`grupo_has_usuario` ;

CREATE  TABLE IF NOT EXISTS `acadnet`.`grupo_has_usuario` (
  `grupo_id_grupo` INT NOT NULL ,
  `usuario_id_usuario` INT NOT NULL ,
  `estado` TINYINT(1) NOT NULL ,
  PRIMARY KEY (`grupo_id_grupo`, `usuario_id_usuario`) ,
  INDEX `fk_grupo_has_usuario_usuario1_idx` (`usuario_id_usuario` ASC) ,
  INDEX `fk_grupo_has_usuario_grupo1_idx` (`grupo_id_grupo` ASC) ,
  CONSTRAINT `fk_grupo_has_usuario_grupo1`
    FOREIGN KEY (`grupo_id_grupo` )
    REFERENCES `acadnet`.`grupo` (`id_grupo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_grupo_has_usuario_usuario1`
    FOREIGN KEY (`usuario_id_usuario` )
    REFERENCES `acadnet`.`usuario` (`id_usuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `acadnet`.`topico`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `acadnet`.`topico` ;

CREATE  TABLE IF NOT EXISTS `acadnet`.`topico` (
  `id_topico` INT NOT NULL AUTO_INCREMENT ,
  `conteudo_topico` TEXT NOT NULL ,
  `data_topico` DATETIME NOT NULL ,
  `usuario_id_usuario` INT NOT NULL ,
  `grupo_id_grupo` INT NOT NULL ,
  PRIMARY KEY (`id_topico`) ,
  INDEX `fk_topico_usuario1_idx` (`usuario_id_usuario` ASC) ,
  INDEX `fk_topico_grupo1_idx` (`grupo_id_grupo` ASC) ,
  CONSTRAINT `fk_topico_usuario1`
    FOREIGN KEY (`usuario_id_usuario` )
    REFERENCES `acadnet`.`usuario` (`id_usuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_topico_grupo1`
    FOREIGN KEY (`grupo_id_grupo` )
    REFERENCES `acadnet`.`grupo` (`id_grupo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `acadnet`.`comentario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `acadnet`.`comentario` ;

CREATE  TABLE IF NOT EXISTS `acadnet`.`comentario` (
  `id_comentario` INT NOT NULL AUTO_INCREMENT ,
  `conteudo_comentario` TEXT NOT NULL ,
  `data_comentario` DATETIME NOT NULL ,
  `usuario_id_usuario` INT NOT NULL ,
  `topico_id_topico` INT NOT NULL ,
  PRIMARY KEY (`id_comentario`) ,
  INDEX `fk_comentario_usuario1_idx` (`usuario_id_usuario` ASC) ,
  INDEX `fk_comentario_topico1_idx` (`topico_id_topico` ASC) ,
  CONSTRAINT `fk_comentario_usuario1`
    FOREIGN KEY (`usuario_id_usuario` )
    REFERENCES `acadnet`.`usuario` (`id_usuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comentario_topico1`
    FOREIGN KEY (`topico_id_topico` )
    REFERENCES `acadnet`.`topico` (`id_topico` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;