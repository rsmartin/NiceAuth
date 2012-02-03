<?php
/**
 * Database Admin View for NiceAuth Plugin
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
<h2>Database Management</h2>

<ul>
	<li><?php echo $this->Html->link('Rebuild ACO Tree', '/dashboard/database/aco', null, 'Are you sure you want to rebuild this tree?'); ?> <span class="small">(Actions & Controllers)</span></li>
	<li><?php echo $this->Html->link('Rebuild ARO Tree', '/dashboard/database/aro', null, 'Are you sure you want to rebuild this tree?'); ?> <span class="small">(Users & Groups)</span></li>
</ul>