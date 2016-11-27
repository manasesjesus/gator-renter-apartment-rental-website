DROP procedure IF EXISTS `getUserDetail`;

DELIMITER $$
CREATE PROCEDURE `getUserDetail` (in userid varchar(25))
BEGIN
IF userid IS NULL THEN 
      Select uid, first_name, last_name, email, address, city, created, user_roles_id, is_active from users where is_active <> 0;
   ELSE
      Select uid, first_name, last_name, email, address, city, created, user_roles_id, is_active from users where uid = userid and is_active <> 0;
   END IF;
END$$

DELIMITER ;

