<h2>Group List</h2>
<?php

echo "<table style=\"width:500px\">";
echo "<thead><th>Group</th></thead>";
foreach($groups as $group) {
	echo "<tr><td>".$group['Group']['name']." <span class=\"small\">(".count($group['User'])." users)</span></td>";
	echo "<td><a href=\"/nice_auth/dashboard/edit_group/".$group['Group']['id']."\">Rename</a></td>";
	echo "<td><a href=\"/nice_auth/dashboard/group_permissions/".$group['Group']['id']."\">Set Permissions</a></td>";
	echo "<td>".$this->Html->link('Delete', '/nice_auth/dashboard/delete_group/'.$group['Group']['id'], array(), 'Are you sure you want to delete this group?')."</td></tr>";
	if ($group['Group']['id'] == $defaultGroup) {
		echo "<td>Default Group</td>";
		}
	}
echo "</table>";

print_r($defaultGroup);

echo "<p>&nbsp;</p>";

echo "<h2>Add Group</h2>";

echo $this->Form->create('Group');
echo $this->Form->input('name');
echo $this->Form->end('Add Group');

?>