<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('User_model');

		if(null === $this->session->userdata('uid')) {
			header("Location: ".site_url('welcome?fa=1')."");
		}
	}

	public function index() {}

	public function logout() {
		session_destroy();
		header("Location: ".site_url('welcome')."?lo=1");
	}

	public function user_accounts() {
		$default_username = "";
		$default_email = "";

		/* Submit form */
		if(null !== $this->input->post('create_user')) {
			/* Validate input */
			$this->form_validation->set_rules('username', 'Username', 'required|is_unique[accounts.username]|alpha_dash|max_length[30]|min_length[6]');
			$this->form_validation->set_rules('password', 'Password', 'required|alpha_dash|max_length[30]|min_length[8]');
			$this->form_validation->set_rules('password2', 'Password confirm', 'required|alpha_dash|max_length[30]|matches[password]');
			$this->form_validation->set_rules('email', 'Email', 'required|max_length[50]|is_unique[accounts.email]|valid_email');
			/* Validation success */
			if ($this->form_validation->run()) {
				$data['create_user'] = $this->User_model->create_user(
								$this->input->post('username'),
								$this->input->post('email'),
								$this->input->post('password')
							);
				if($data['create_user'] == 1) { // Database insert success, refresh page, display alert msg, clear fields
					header("Location: ".site_url('user/user_accounts')."?create_alert=Success");
				}else { // Database insert failed, display alert msg, repopulate fields
					$data['create_alert'] = "Failed! Please try again.";
					$default_username = set_value('username');
					$default_email = set_value('email');
				}
			}else { // Validation failed, repopulate fields
				$default_username = set_value('username');
				$default_email = set_value('email');
			}
		}else if(null !== $this->input->post('reset')) {
			header("Location: ".site_url('user/user_accounts')."");
		}

		/* Create form */
		$form = 	array('class' => 'form-horizontal user-form');
		$username = array('name' => 'username', 
						'id' => 'username', 
						'value' => $default_username, 'maxlength' => '30', 
						'placeholder' => 'Username', 
						'class' => 'form-control username', 
						'style' => ''
					);
		$email = 	array('name' => 'email', 
						'id' => 'email', 
						'value' => $default_email, 'maxlength' => '50', 
						'placeholder' => 'Email Address', 
						'class' => 'form-control email', 
						'style' => ''
					);
		$password1 = array('name' => 'password', 
						'id' => 'password', 
						'type' => 'password', 
						'maxlength' => '30', 
						'placeholder' => 'Password', 
						'class' => 'form-control password',	'size' => '30', 
						'style' => ''
					);
		$password2 = array('name' => 'password2', 
						'id' => 'password2', 
						'type' => 'password', 
						'maxlength' => '30', 
						'placeholder' => 'Password Confirm', 
						'class' => 'form-control password',	'style' => ''
					);
		$reset = 	array('name' => 'reset', 
						'id' => 'reset', 
						'value' => 'Clear', 
						'class' => 'btn btn-normal', 
						'style' => ''
					);
		$submit = 	array('name' => 'create_user', 
						'id' => 'submit', 
						'value' => 'Submit', 
						'class' => 'btn btn-cyan', 
						'style' => ''
					);
		$data['form'] =  form_open('user/user_accounts', $form)
						.heading('User Accounts', 3, 'class="section-title"')
						.form_input($username)
						.form_input($email)
						.form_input($password1)
						.form_input($password2)
						.form_submit($reset)
						.form_submit($submit) 
						.form_close();
		
		/* Get list */
		$list = $this->User_model->get_user();

		/* Generate table */
		$this->table->set_heading('Username', 'Email', '&nbsp;');
		if(null !== $list) {
			foreach ($list as $l):
				$this->table->add_row($l['username'], $l['email'], '&nbsp;');
			endforeach;
		}

		$template = array('table_open' => '<table class="table table-striped myTable">');

		$this->table->set_template($template);
		$data['user_table'] = $this->table->generate();


		$this->load->view('header');
		$this->load->view('users/user-accounts', $data);
		$this->load->view('navbar');
		$this->load->view('footer');
	}
}