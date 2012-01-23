SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `default_schema` ;

CREATE SCHEMA IF NOT EXISTS `es-matrix-future` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;

USE `es-matrix-future`;

CREATE  TABLE IF NOT EXISTS `es-matrix-future`.`environment` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  `user_agent` VARCHAR(255) NOT NULL ,
  `version_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `name` (`name` ASC) ,
  UNIQUE INDEX `user_agent` (`user_agent` ASC) ,
  INDEX `fk_environment_version1` (`version_id` ASC) ,
  CONSTRAINT `fk_environment_version1`
    FOREIGN KEY (`version_id` )
    REFERENCES `es-matrix-future`.`version` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE  TABLE IF NOT EXISTS `es-matrix-future`.`feature` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `code` VARCHAR(512) NOT NULL ,
  `title` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 262
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE  TABLE IF NOT EXISTS `es-matrix-future`.`result` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `testcase_id` INT(10) UNSIGNED NOT NULL ,
  `environment_id` INT(10) UNSIGNED NOT NULL ,
  `value` TINYINT(1) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `testcase_id` (`testcase_id` ASC, `environment_id` ASC) ,
  INDEX `environment_id` (`environment_id` ASC) ,
  CONSTRAINT `result_ibfk_1`
    FOREIGN KEY (`testcase_id` )
    REFERENCES `es-matrix-future`.`testcase` (`id` ),
  CONSTRAINT `result_ibfk_2`
    FOREIGN KEY (`environment_id` )
    REFERENCES `es-matrix-future`.`environment` (`id` ))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = 'Test results';

CREATE  TABLE IF NOT EXISTS `es-matrix-future`.`testcase` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `feature_id` INT(10) UNSIGNED NOT NULL ,
  `title` VARCHAR(255) NOT NULL ,
  `code` TEXT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `feature_id` (`feature_id` ASC) ,
  CONSTRAINT `testcase_ibfk_1`
    FOREIGN KEY (`feature_id` )
    REFERENCES `es-matrix-future`.`feature` (`id` ))
ENGINE = InnoDB
AUTO_INCREMENT = 271
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE  TABLE IF NOT EXISTS `es-matrix-future`.`implementation` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(25) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE  TABLE IF NOT EXISTS `es-matrix-future`.`version` (
  `id` INT(11) NOT NULL ,
  `implementation_id` INT(10) UNSIGNED NOT NULL ,
  `name` VARCHAR(25) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_version_implementation1` (`implementation_id` ASC) ,
  CONSTRAINT `fk_version_implementation1`
    FOREIGN KEY (`implementation_id` )
    REFERENCES `es-matrix-future`.`implementation` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE SCHEMA IF NOT EXISTS `es-matrix-old` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;

USE `es-matrix-old`;

CREATE  TABLE IF NOT EXISTS `es-matrix-old`.`environment` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  `user_agent` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `name` (`name` ASC) ,
  UNIQUE INDEX `user_agent` (`user_agent` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE  TABLE IF NOT EXISTS `es-matrix-old`.`feature` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `code` VARCHAR(512) NOT NULL ,
  `title` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 262
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE  TABLE IF NOT EXISTS `es-matrix-old`.`result` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `testcase_id` INT(10) UNSIGNED NOT NULL ,
  `environment_id` INT(10) UNSIGNED NOT NULL ,
  `value` TINYINT(1) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `testcase_id` (`testcase_id` ASC, `environment_id` ASC) ,
  INDEX `environment_id` (`environment_id` ASC) ,
  CONSTRAINT `result_ibfk_1`
    FOREIGN KEY (`testcase_id` )
    REFERENCES `es-matrix-old`.`testcase` (`id` ),
  CONSTRAINT `result_ibfk_2`
    FOREIGN KEY (`environment_id` )
    REFERENCES `es-matrix-old`.`environment` (`id` ))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = 'Test results';

CREATE  TABLE IF NOT EXISTS `es-matrix-old`.`testcase` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `feature_id` INT(10) UNSIGNED NOT NULL ,
  `title` VARCHAR(255) NOT NULL ,
  `code` TEXT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `feature_id` (`feature_id` ASC) ,
  CONSTRAINT `testcase_ibfk_1`
    FOREIGN KEY (`feature_id` )
    REFERENCES `es-matrix-old`.`feature` (`id` ))
ENGINE = InnoDB
AUTO_INCREMENT = 271
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
