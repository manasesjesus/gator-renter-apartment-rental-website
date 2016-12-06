/*
@Created by: Hassaan Ahmed Rana - 06-12-2016

@Modified by:
*/

DROP procedure IF EXISTS `deleteFavApartment`;

DELIMITER $$
CREATE PROCEDURE `deleteFavApartment` 
(
    in apartment_id int(11),
    in email varchar(50)
 )
BEGIN
	
    DELETE uaf
    FROM user_apartments_fav uaf
	INNER JOIN users u on u.uid = uaf.user_id
    WHERE
		uaf.apartment_id = apartment_id
        AND u.email = email;
    
END$$

DELIMITER ;

