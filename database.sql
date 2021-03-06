-- MySQL Script generated by MySQL Workbench
-- Sun Mar 31 15:11:49 2019
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema bachelor
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema bachelor
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `bachelor` DEFAULT CHARACTER SET utf8mb4 ;
USE `bachelor` ;

-- -----------------------------------------------------
-- Table `bachelor`.`location`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bachelor`.`location` (
  `location_id` INT NOT NULL AUTO_INCREMENT,
  `campus` VARCHAR(50) NOT NULL COMMENT 'Корпус',
  `auditory` VARCHAR(50) NOT NULL COMMENT 'Аудитория',
  PRIMARY KEY (`location_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bachelor`.`equipment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bachelor`.`equipment` (
  `equipment_id` INT NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(50) NOT NULL COMMENT 'Тип оргтехники (принтер, компьютер и т.д.)',
  `manufacturer` VARCHAR(255) NOT NULL COMMENT 'Производитель',
  PRIMARY KEY (`equipment_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bachelor`.`furniture`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bachelor`.`furniture` (
  `furniture_id` INT NOT NULL AUTO_INCREMENT,
  `specifications` TEXT(65535) NOT NULL,
  PRIMARY KEY (`furniture_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bachelor`.`material_value`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bachelor`.`material_value` (
  `material_value_id` INT NOT NULL AUTO_INCREMENT,
  `type` ENUM('assets', 'furniture', 'equipment') NOT NULL COMMENT 'Тип материальной ценности',
  `inventory_num` VARCHAR(20) NOT NULL COMMENT 'Инвентарный номер',
  `serial_num` VARCHAR(20) NULL COMMENT 'Серийный номер',
  `name` VARCHAR(255) NOT NULL COMMENT 'Имя',
  `description` TEXT(65535) NULL COMMENT 'Описание',
  `price` DECIMAL UNSIGNED NULL COMMENT 'Цена',
  `count` INT UNSIGNED NOT NULL COMMENT 'Количество',
  `enter_date` DATE NOT NULL COMMENT 'Дата ввода в эксплуатацию',
  `exit_date` DATE NULL COMMENT 'Дата списания',
  `photo` VARCHAR(255) NULL COMMENT 'Название файла с фотографией',
  `location_location_id` INT NOT NULL,
  `equipment_equipment_id` INT NULL,
  `furniture_furniture_id` INT NULL,
  PRIMARY KEY (`material_value_id`),
  INDEX `fk_material_value_location_idx` (`location_location_id` ASC),
  INDEX `fk_material_value_equipment_idx` (`equipment_equipment_id` ASC),
  INDEX `fk_material_value_furniture_idx` (`furniture_furniture_id` ASC),
  CONSTRAINT `fk_material_value_location`
    FOREIGN KEY (`location_location_id`)
    REFERENCES `bachelor`.`location` (`location_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_material_value_equipment`
    FOREIGN KEY (`equipment_equipment_id`)
    REFERENCES `bachelor`.`equipment` (`equipment_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_material_value_furniture`
    FOREIGN KEY (`furniture_furniture_id`)
    REFERENCES `bachelor`.`furniture` (`furniture_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bachelor`.`license`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bachelor`.`license` (
  `license_id` INT NOT NULL AUTO_INCREMENT,
  `po_name` VARCHAR(255) NOT NULL COMMENT 'Имя программного обеспечения',
  `po_version` VARCHAR(255) NOT NULL COMMENT 'Версия программного обеспечения',
  `license_number` VARCHAR(255) NOT NULL COMMENT 'Номер (ключ) лицензии',
  `end_date` DATE NOT NULL COMMENT 'Дата окончания лицензии',
  PRIMARY KEY (`license_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bachelor`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bachelor`.`user` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `first_name` VARCHAR(45) NOT NULL,
  `second_name` VARCHAR(45) NOT NULL,
  `third_name` VARCHAR(45) NULL,
  `title` VARCHAR(45) NULL,
  `role` ENUM('admin', 'readonly') NOT NULL,
  PRIMARY KEY (`user_id`));


-- -----------------------------------------------------
-- Table `bachelor`.`equipment_has_license`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bachelor`.`equipment_has_license` (
  `equipment_equipment_id` INT NOT NULL,
  `license_license_id` INT NOT NULL,
  PRIMARY KEY (`equipment_equipment_id`, `license_license_id`),
  INDEX `fk_equipment_has_license_license1_idx` (`license_license_id` ASC),
  INDEX `fk_equipment_has_license_equipment1_idx` (`equipment_equipment_id` ASC),
  CONSTRAINT `fk_equipment_has_license_equipment`
    FOREIGN KEY (`equipment_equipment_id`)
    REFERENCES `bachelor`.`equipment` (`equipment_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipment_has_license_license`
    FOREIGN KEY (`license_license_id`)
    REFERENCES `bachelor`.`license` (`license_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bachelor`.`specification`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bachelor`.`specification` (
  `specifications_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL COMMENT 'Имя характеристики',
  `expected_max_value` DOUBLE NOT NULL COMMENT 'Ожидаемое максимальное значение характеристики (износ)',
  PRIMARY KEY (`specifications_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bachelor`.`equipment_has_specification`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bachelor`.`equipment_has_specification` (
  `equipment_equipment_id` INT NOT NULL,
  `specification_specification_id` INT NOT NULL,
  `current_value` DOUBLE NOT NULL COMMENT 'Текущее значение характеристики',
  PRIMARY KEY (`equipment_equipment_id`, `specification_specification_id`),
  INDEX `fk_equipment_has_specification_specification1_idx` (`specification_specification_id` ASC),
  INDEX `fk_equipment_has_specification_equipment1_idx` (`equipment_equipment_id` ASC),
  CONSTRAINT `fk_equipment_has_specification_equipment1`
    FOREIGN KEY (`equipment_equipment_id`)
    REFERENCES `bachelor`.`equipment` (`equipment_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipment_has_specification_specification1`
    FOREIGN KEY (`specification_specification_id`)
    REFERENCES `bachelor`.`specification` (`specifications_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
