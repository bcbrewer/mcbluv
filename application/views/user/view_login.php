<div id="login_form">
	<h1>Please Login</h1>
		
		<?php
			$attributes = array('class' => 'user', 'id' => 'login');
			echo form_open('c=user&amp;m=login', $attributes); // this will lead you to whatever page after the login
		?>
		
		<ul class="login">
			
			<li>
			<label>Username:</label>	
				<div>
					<?php echo form_input(array('id' => 'username', 'name' => 'username')); ?>
				</div>
			</li>
			
			<li>
			<label>Password:</label>	
				<div>
					<?php echo form_password(array('id' => 'password', 'name' => 'password')); ?>
				</div>
			</li>
			
			<li>
			<?php
				if ($this->session->flashdata('login_error')) {
					echo "You entered an incorrect username or password";
				}
				 echo validation_errors(); 
			?>
			</li>
			
			<li>
				<?php echo form_submit(array('name' => 'submit'), 'Login'); ?>
			</li>
			
		</ul>	
		
		<?php echo form_close(); ?>
		
	</div>