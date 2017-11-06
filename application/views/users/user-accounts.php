<div class="container">
	<div class="row">
		<div class='col-sm-12'>
			<h1 class="page-header">User Accounts</h1>
		</div>
	</div>
	<div class="row">
		<div class='col-sm-6 col-md-4'>
			<?php
				if(isset($form)) {
					echo $form;
					echo validation_errors();
					if(isset($create_alert)) {
						echo $create_alert;
					}else if(null !== $this->input->get('create_alert')) {
						echo $this->input->get('create_alert');
					}
				}
				else {
					echo "Page not found."; 
				}
			?>
		</div>
		<div class="col-sm-6 col-md-8">
			<h3 class="section-title">Existing Users</h3>
				<?php
					if(isset($user_table)) {
						echo $user_table;
					}
					else {
						echo "No records found."; 
					}
				?>
		</div>
	</div>
</div>

