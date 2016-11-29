DROP procedure IF EXISTS `getMessages`;

DELIMITER $$
CREATE PROCEDURE `getMessages` 
(in email varchar(50), 
 in apartment_id int, 
 in fromuser_email varchar(50)
 )
BEGIN
	
    SELECT
	sed.first_name + ' ' + sed.last_name as from_user_name
        ,sed.email as from_user_email
        ,um.created as received_date
        ,a.id as apartment_id
        ,a.title as apartment_title
        ,a.active as apartment_active
        ,um.message as message
	FROM
		user_messages um
		INNER JOIN users rec ON rec.id = um.to_user_id
        INNER JOIN users sed ON sed.id = um.from_user_id
        INNER JOIN apartments a ON a.id = um.apartment_id
	WHERE
		rec.email = email
        AND (sed.email = fromuser_email OR fromuser_email IS NULL)
        AND (um.apartment_id = apartment_id OR apartment_id IS NULL)
	ORDER BY
		um.created desc;
END$$

DELIMITER ;

