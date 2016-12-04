/*
@Created by: Hassaan Ahmed Rana - 04-12-2016

@Modified by:
*/

DROP procedure IF EXISTS `getApartments`;

DELIMITER $$
CREATE PROCEDURE `getApartments` 
(
	in private_room tinyint(1),
	in private_bath tinyint(1),
	in kitchen_in_apartment tinyint(1),
    in has_security_deposit tinyint(1),
    in credit_score_check tinyint(1),
    in owner_id int(11),
    in apartment_id int(11),
    in monthly_rent_min double,
    in monthly_rent_max double,
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
		*
	FROM
    (
		SELECT 
			*,
            @row_number:=@row_number + 1 as row_number
		FROM 
			apartments a
		WHERE
			(a.id = apartment_id OR apartment_id IS NULL)
			AND (a.private_room = private_room OR private_room IS NULL)
			AND (a.private_bath = private_bath OR private_bath IS NULL)
			AND (a.kitchen_in_apartment = kitchen_in_apartment OR kitchen_in_apartment IS NULL)
			AND (a.has_security_deposit = has_security_deposit OR has_security_deposit IS NULL)
			AND (a.credit_score_check = credit_score_check OR credit_score_check IS NULL)
			AND (a.owner_id = owner_id OR owner_id IS NULL)
            AND (a.monthly_rent >= monthly_rent_min OR monthly_rent_min IS NULL)
            AND (a.monthly_rent <= monthly_rent_max OR monthly_rent_max IS NULL)
            
		ORDER BY
			a.updated_at DESC
	) result WHERE row_number between limit_start and limit_end;

        
    
END$$

DELIMITER ;