<?php
return;
/* Post information */
if(isset($_POST)){
	var_dump($_POST);
}

printf(__('Userid: %s'),get_current_user_id());


global $wpdb;
echo "<pre>";
print_r($wpdb->queries);
echo "</pre>";
