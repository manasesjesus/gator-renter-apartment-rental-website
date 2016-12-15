DROP procedure IF EXISTS `addMessage`;

DELIMITER $$
CREATE PROCEDURE `addMessage`(in in_from_user_id varchar(50), in in_to_user_id varchar(255),
                              in in_apartment_id varchar(255), in in_message varchar(1000))
  BEGIN

    INSERT INTO user_messages (from_user_id, to_user_id, apartment_id, message, created)
    VALUES (in_from_user_id, in_to_user_id, in_apartment_id, in_message, DATE_ADD(UTC_TIMESTAMP(), INTERVAL 1 HOUR));

  END$$

DELIMITER ;