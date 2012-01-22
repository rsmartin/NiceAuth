<h2>Register your account</h2> 

<?php

echo $this->Form->create('User');
echo $this->Form->input('username');
echo $this->Form->input('password');
echo $this->Form->end('Register');

?>