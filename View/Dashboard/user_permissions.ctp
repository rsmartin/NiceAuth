<?php 

echo "<h2>Edit permissions for ".$user['User']['username']."</h2>";

echo "<table style=\"width:600px\">";
echo "<thead><th>ACO</th><th>Permission (click to change)</th></thead>";

foreach($perms as $perm) {
	echo "<tr>";
		echo "<td>".$perm['Aco']['alias']."</td>";
		//echo "<td>".$perm['Aco']['perm']."</td>";
		if ($perm['Aco']['perm'] == 'allow') {

			echo "<td>";
			
			echo $this->Html->link(
				$this->Html->image('/nice_auth/img/allow.png', array('alt' => 'Set to Deny', 'width' => '30')),
				array(
					'plugin' => 'nice_auth',
					'controller' => 'dashboard',
					'action' => 'user_permissions',
					$user['User']['id'],
					'?' => array(
						'perm' => 'deny',
						'aro' => $user['User']['username'],
						'aco' => $perm['Aco']['alias']
						)
					),
				array('escape' => false)
				);
			
			echo "</td>";

			}
		else {
			
			echo "<td>";
			
			echo $this->Html->link(
				$this->Html->image('/nice_auth/img/deny.png', array('alt' => 'Set to Allow', 'width' => '30')),
				array(
					'plugin' => 'nice_auth',
					'controller' => 'dashboard',
					'action' => 'user_permissions',
					$user['User']['id'],
					'?' => array(
						'perm' => 'allow',
						'aro' => $user['User']['username'],
						'aco' => $perm['Aco']['alias']
						)
					),
				array('escape' => false)
				);
			
			echo "</td>";
			
			}
	echo "</tr>";
	}

echo "</table>"

?>