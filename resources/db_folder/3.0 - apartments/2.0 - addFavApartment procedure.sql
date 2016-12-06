/*
@Created by: Hassaan Ahmed Rana - 06-12-2016

@Modified by:
*/

DROP procedure IF EXISTS `addFavApartment`;

DELIMITER $$
CREATE PROCEDURE `addFavApartment` 
(
    in apartment_id int(11),
    in email varchar(50)
 )
BEGIN
	
    INSERT INTO user_apartments_fav (user_id, apartment_id) 
		SELECT
			u.uid, apartment_id
		FROM
			users u
		WHERE u.email = email;
        
    
END$$

DELIMITER ;

