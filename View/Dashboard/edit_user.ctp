<h2>Edit user account</h2> 

<?php

echo $this->Form->create('User');
echo $this->Form->input('username');
echo $this->Form->input('password', array('value' => '', 'label' => 'Password (leave blank if not modified)'));
echo $this->Form->input('group_id');
echo $this->Form->end('Update');

?>