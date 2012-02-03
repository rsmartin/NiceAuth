<?php
/**
 * Group Permissions View for NiceAuth Plugin
 *
 * NiceAuth : User Authentication and Authorization Plugin for CakePHP
 * Copyright 2011, R.S.Martin (http://rsmartin.me)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author RSMartin
 * @copyright Copyright (c) 2011, RSMartin (http://rsmartin.me)
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
?>
<?php 

echo "<h2>Edit permissions for ".$group['Group']['name']."</h2>";

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
					'action' => 'group_permissions',
					$group['Group']['id'],
					'?' => array(
						'perm' => 'deny',
						'aro' => $group['Group']['name'],
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
					'action' => 'group_permissions',
					$group['Group']['id'],
					'?' => array(
						'perm' => 'allow',
						'aro' => $group['Group']['name'],
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