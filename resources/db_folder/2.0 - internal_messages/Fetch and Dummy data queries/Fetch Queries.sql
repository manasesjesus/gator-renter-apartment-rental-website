
# this query returns latest message by tenants for each apartment a particular landord has posted
select concat(sender.first_name, ' ' , sender.last_name) `sender_name`,
	   sender.email `sender_email`,
       um.created `receive_date`,
       um.message `sender_message`,
       apt.id `apartment_id`,
       apt.title `apartment_title`,
       apt.active `is_active`
from user_messages um
left join users sender on (sender.uid = um.from_user_id) 
left join apartments apt on (apt.id = um.apartment_id) 
where um.id in (
    # getting latest messages sent to landlords grouped by tenants and their posted apartments
	select max(um.id) from user_messages um
	group by um.from_user_id, um.apartment_id 
) and um.to_user_id = 171;



