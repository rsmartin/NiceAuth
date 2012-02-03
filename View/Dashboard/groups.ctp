<?php
/**
 * Group List View for NiceAuth Plugin
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
<h2>Group List</h2>

<table>
<tr>
		<th><?php echo $this->Paginator->sort('name');?></th>
		<th><?php echo $this->Paginator->sort('created');?></th>
		<th><?php echo $this->Paginator->sort('modified');?></th>
		<th colspan="3" class="actions"><?php echo __('Actions');?></th>
</tr>

<?php
foreach($groups as $group) {
	echo "<tr>";
		echo "<td>".$group['Group']['name']." <span class=\"small\">(".count($group['User'])." users)</span></td>";
		echo "<td>".$group['Group']['created']."</td>";
		echo "<td>".$group['Group']['modified']."</td>";
		echo "<td>".$this->Html->link('Rename', '/dashboard/group_edit/'.$group['Group']['id'])."</td>";
		echo "<td>".$this->Html->link('Set Permissions', '/dashboard/group_permissions/'.$group['Group']['id'])."</td>";
		echo "<td>".$this->Html->link('Delete', '/dashboard/group_delete/'.$group['Group']['id'], array(), 'Are you sure you want to delete this group?')."</td>";
		if ($group['Group']['id'] == $defaultGroup) {
			echo "<td>Default Group</td>";
			}
	echo "</tr>";
	}
?>
</table>

<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
));
?>	</p>

<div class="paging">
<?php
	echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
	echo $this->Paginator->numbers(array('separator' => ''));
	echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
?>
</div>


<p>&nbsp;</p>
<h2>Add Group</h2>

<?php
echo $this->Form->create('Group');
echo $this->Form->input('name');
echo $this->Form->end('Add Group');
?>