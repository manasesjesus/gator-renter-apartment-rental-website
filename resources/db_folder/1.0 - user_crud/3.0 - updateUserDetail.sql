DROP procedure IF EXISTS `updateUserDetail`;

DELIMITER $$
CREATE PROCEDURE `updateUserDetail` (in email varchar(50), in first_name varchar(255), 
in last_name varchar(255), in address varchar(50), in city varchar(50))
BEGIN
	
    UPDATE 
		users u
	SET
		u.first_name = first_name,
        u.last_name = last_name,
        u.address = address,
        u.city = city
	WHERE
		u.email = email;
        
	SELECT
		*
	FROM
		users u
	WHERE
		u.email = email;
    
END$$

DELIMITER ;

