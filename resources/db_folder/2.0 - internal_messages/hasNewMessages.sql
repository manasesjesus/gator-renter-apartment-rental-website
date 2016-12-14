DROP procedure IF EXISTS `hasNewMessages`;

DELIMITER $$
USE `mini`$$
CREATE PROCEDURE `hasNewMessages` (	in email varchar(50))
BEGIN

	SELECT
		count(um.id) new_messages_count
	FROM
		user_messages um
        INNER JOIN users u ON um.to_user_id = u.uid
		AND u.email = email
        WHERE
            um.is_new_message = 1;

END$$

DELIMITER ;
