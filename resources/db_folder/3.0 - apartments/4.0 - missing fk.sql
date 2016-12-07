ALTER TABLE `apartments` 
ADD INDEX `pk_owner_id_idx` (`owner_id` ASC);
ALTER TABLE `apartments` 
ADD CONSTRAINT `pk_owner_id`
  FOREIGN KEY (`owner_id`)
  REFERENCES `users` (`uid`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


ALTER TABLE `pictures` 
ADD INDEX `fk_apt_id1_idx` (`apartment_id` ASC),
DROP INDEX `fk_apt_id_1_idx` 
ALTER TABLE `pictures` 
ADD CONSTRAINT `fk_apt_id1`
  FOREIGN KEY (`apartment_id`)
  REFERENCES `apartments` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


  