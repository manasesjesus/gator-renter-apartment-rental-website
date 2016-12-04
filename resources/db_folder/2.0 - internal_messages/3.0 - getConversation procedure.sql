/*
@Created by: Hassaan Ahmed Rana - 02-12-2016

@Modified by:
*/

DROP procedure IF EXISTS `getConversation`;

DELIMITER $$
CREATE PROCEDURE `getConversation` 
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
        ,to_user
        ,to_user_email
        ,from_user_id
        ,to_user_id
        ,received_on
        ,message
        ,is_received
        ,apt_id
        ,apartment_title
        ,apartment_active
	FROM
        (
		SELECT
			@row_number:=@row_number + 1 as row_number,
			CONCAT(sed.first_name, ' ' ,sed.last_name) as from_user,
			sed.email from_user_email,
			CONCAT(rec.first_name, ' ' ,rec.last_name) as to_user,
			rec.email to_user_email,
			um.from_user_id,
			um.to_user_id,
			um.created received_on,
			um.message,
			CASE WHEN um.from_user_id = sed.uid THEN 1
			ELSE 0 END as is_received
			,a.id as apt_id
			,a.title as apartment_title
			,a.active as apartment_active
		FROM
			user_messages um
			INNER JOIN users rec ON rec.uid = um.to_user_id
			INNER JOIN users sed ON sed.uid = um.from_user_id
			INNER JOIN apartments a ON a.id = um.apartment_id
		WHERE
			(sed.email = fromuser_email
				AND rec.email = email
            )
            OR (sed.email = email
				AND rec.email = fromuser_email
			)
			AND (um.apartment_id = apartment_id OR apartment_id IS NULL)
			AND a.id = um.apartment_id
            AND a.active = 1
		ORDER BY um.created desc
		) con WHERE row_number between limit_start and limit_end;
        
END$$

DELIMITER ;

