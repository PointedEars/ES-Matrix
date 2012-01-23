SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `implementation`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `implementation` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(25) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `version`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `version` (
  `id` INT NOT NULL ,
  `implementation_id` INT UNSIGNED NOT NULL ,
  `name` VARCHAR(25) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_version_implementation1` (`implementation_id` ASC) ,
  CONSTRAINT `fk_version_implementation1`
    FOREIGN KEY (`implementation_id` )
    REFERENCES `implementation` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `environment`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `environment` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  `user_agent` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `name` (`name` ASC) ,
  UNIQUE INDEX `user_agent` (`user_agent` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `feature`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `feature` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `code` VARCHAR(512) NOT NULL ,
  `title` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 262
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `testcase`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `testcase` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `feature_id` INT(10) UNSIGNED NOT NULL ,
  `title` VARCHAR(255) NOT NULL ,
  `code` TEXT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `feature_id` (`feature_id` ASC) ,
  CONSTRAINT `testcase_ibfk_1`
    FOREIGN KEY (`feature_id` )
    REFERENCES `feature` (`id` ))
ENGINE = InnoDB
AUTO_INCREMENT = 271
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `result`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `result` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `testcase_id` INT(10) UNSIGNED NOT NULL ,
  `environment_id` INT(10) UNSIGNED NOT NULL ,
  `value` TINYINT(1) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `testcase_id` (`testcase_id` ASC, `environment_id` ASC) ,
  INDEX `environment_id` (`environment_id` ASC) ,
  CONSTRAINT `result_ibfk_1`
    FOREIGN KEY (`testcase_id` )
    REFERENCES `testcase` (`id` ),
  CONSTRAINT `result_ibfk_2`
    FOREIGN KEY (`environment_id` )
    REFERENCES `environment` (`id` ))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Test results';


-- -----------------------------------------------------
-- Table `environment`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `environment` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  `user_agent` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `name` (`name` ASC) ,
  UNIQUE INDEX `user_agent` (`user_agent` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `feature`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `feature` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `code` VARCHAR(512) NOT NULL ,
  `title` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 262
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `testcase`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `testcase` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `feature_id` INT(10) UNSIGNED NOT NULL ,
  `title` VARCHAR(255) NOT NULL ,
  `code` TEXT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `feature_id` (`feature_id` ASC) ,
  CONSTRAINT `testcase_ibfk_1`
    FOREIGN KEY (`feature_id` )
    REFERENCES `feature` (`id` ))
ENGINE = InnoDB
AUTO_INCREMENT = 271
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `result`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `result` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `testcase_id` INT(10) UNSIGNED NOT NULL ,
  `environment_id` INT(10) UNSIGNED NOT NULL ,
  `value` TINYINT(1) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `testcase_id` (`testcase_id` ASC, `environment_id` ASC) ,
  INDEX `environment_id` (`environment_id` ASC) ,
  CONSTRAINT `result_ibfk_1`
    FOREIGN KEY (`testcase_id` )
    REFERENCES `testcase` (`id` ),
  CONSTRAINT `result_ibfk_2`
    FOREIGN KEY (`environment_id` )
    REFERENCES `environment` (`id` ))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Test results';



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
