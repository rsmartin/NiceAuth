<h2>Lost Password?</h2>
<p>By clicking Reset Password, you will receive an email with direction to reset your password.</p>

<?php
echo $this->Form->create('User');
echo $this->Form->input('email');
echo $this->Form->end('Reset Password');