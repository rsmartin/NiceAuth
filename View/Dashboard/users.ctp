<h2>User List</h2>
<?php

echo "<table style=\"width:500px\">";
echo "<thead><th>Username</th><th>Group</th></thead>";
foreach($users as $user) {
	echo "<tr><td>".$user['User']['username']."</td>";
	echo "<td>".$groups[$user['User']['group_id']]."</td>";
	echo "<td><a href=\"/nice_auth/dashboard/edit_user/".$user['User']['id']."\">edit</a></td>";
	echo "<td><a href=\"/nice_auth/dashboard/user_permissions/".$user['User']['id']."\">custom permissions</a></td></tr>";
	}
echo "</table>";

?>