/*
@Created by: Hassaan Ahmed Rana - 02-12-2016

@Modified by:
*/

DROP procedure IF EXISTS `getMessages`;

DELIMITER $$
CREATE PROCEDURE `getMessages` 
(
	in email varchar(50), 
	in apartment_id int, 
	in fromuser_email varchar(50),
    in page_number int,
    in page_size int
 )
BEGIN

	DECLARE limit_start int;
    DECLARE limit_end int;
    SET @row_number:=0;
    SET limit_start = (page_number - 1) * page_size;
    SET limit_end = limit_start + page_size;
    SET limit_start = limit_start + 1;
    
    SELECT
		from_user
        ,from_user_email
        ,received_date
        ,apt_id
        ,apartment_title
        ,apartment_active
        ,received_on
        ,message
    FROM
    (
		SELECT
			@row_number:=@row_number + 1 as row_number
			,CONCAT(sed.first_name, ' ' ,sed.last_name) as from_user
			,sed.email as from_user_email
			,um.created as received_date
			,um.apartment_id as apt_id
			,a.title as apartment_title
			,a.active as apartment_active
			,um.created as received_on
			,um.message as message
		FROM
			(
				SELECT
					um.from_user_id as from_user_id
                    ,um.apartment_id
					,MAX(um.created) as last_received_on
				FROM user_messages um
				INNER JOIN users sed ON sed.uid = um.from_user_id
				INNER JOIN users rec ON rec.uid = um.to_user_id
				WHERE
					(um.apartment_id = apartment_id OR apartment_id IS NULL)
					AND (sed.email = fromuser_email OR fromuser_email IS NULL)
					AND rec.email = email
				GROUP BY
					um.from_user_id
                    ,um.apartment_id
			) umax
			INNER JOIN user_messages um ON um.created = umax.last_received_on 
				AND um.from_user_id = umax.from_user_id
			INNER JOIN users rec ON rec.uid = um.to_user_id
			INNER JOIN users sed ON sed.uid = um.from_user_id
			INNER JOIN apartments a ON a.id = um.apartment_id
		WHERE
			rec.email = email
			AND a.active = 1
		ORDER BY um.created desc
				 ,from_user_email
    ) result WHERE row_number between limit_start and limit_end;

END$$

DELIMITER ;

