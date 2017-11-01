<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->output->delete_cache();
		$this->load->model('User_model');
	}

	public function index() {
		if(null !== $this->input->post('login')) {
			/* Input validation */
			$this->form_validation->set_rules('password', 'Password', 'required|alpha_dash|max_length[30]');
			$this->form_validation->set_rules('email', 'Email', 'required|max_length[50]|valid_email');
			/* Valid */
			if ($this->form_validation->run()) {
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				/* Check credentials */
				$data['check_user'] = $this->User_model->check_user($email, $password);
				if($data['check_user']) {
					header("Location: ".site_url('user/user_accounts').""); // Redirect to admin page
				}else {
					$data['check_user'] = "Invalid username/password."; // Create error message
				}
			}
		}
		
		/* Create login form */
		$form =  array('class' => 'form-horizontal login-form', );
		$email = array('name' => 'email', 
					'id' => 'email', 
					'value' => set_value('email'), 'maxlength' => '50', 
					'placeholder' => 'admin123@admin.com', 
					'class' => 'form-control email', 
					'style' => ''
				);
		$password = array('name' => 'password', 
					'id' => 'password', 
					'type' => 'password', 
					'maxlength' => '30', 
					'placeholder' => 'admin123', 
					'class' => 'form-control password', 
					'size' => '30', 
					'style' => ''
				);
		$submit = array('name' => 'login', 
					'id' => 'submit', 
					'value' => 'Sign in', 
					'class' => 'btn btn-primary submit', 
					'style' => ''
				);
		$data['form'] =  form_open('welcome', $form).heading('Login', 1, 'class="page-header"')
						.heading('Please sign in to your account', 5, 'class="form-sub"')
						.form_input($email)
						.form_input($password)
						.form_submit($submit)
						.form_close();
		
		$this->load->view('header');
		$this->load->view('login-page', $data);
		$this->load->view('footer');
	}

}
