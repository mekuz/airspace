<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ResetPassModel;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

class User extends BaseController
{
	public function __construct() {
		helper(['form', 'url']); //call helpers
	}//end constructor

	public function index() {
		//if(!isset($_SESSION['user']))//not logged in

	header('Location: '.base_url('art')); // go to entry



	}//end method indexa




	public function register() {
		//start blank


		helper(['form', 'url']); //call helpers
		$validation = \Config\Services::validation();

		$data['title'] = 'Register';

		$validation->setRule('name', 'Name', 'required');

		$validation->setRule('email', 'E-mail', 'required|valid_email|is_unique[users.email]');
		$validation->setRule('phone', 'Phone Number', 'required|numeric|integer');
		$validation->setRule('password', 'Password', 'required|min_length[6]');


		if ($validation->withRequest($this->request)
			->run() === FALSE)//empty or with errors
		{
			if ($this->request->getMethod() === 'get') {
				//fresh form

			} else
			{
				//post, came with errors
				$data['error'] = $validation->listErrors();
			}


			echo view('user/user_header');
			echo view('user/reg_view', $data);
			echo view('user/user_footer');

		} else //filled correctly
		{
			$details = array(
				'user_type' => 'user',
				'password' => $this->request->getPost('password'),
				'email' => $this->request->getPost('email'),
				'phone_number' => $this->request->getPost('phone'),
				'name' => $this->request->getPost('name'),
			); //end array
			$userModel = new UserModel();
			$userModel->insert($details); //get inserted to database

			$user = $userModel->getWhere(['user_id' => $userModel->insertID])->getFirstRow(); //get newly created user

			$session = \Config\Services::session();
			$session->set('user', $user); //set user for the session
			header('Location: '.base_url('dashboard')); // go to entry
		}
	}//end reg



	public function login($info = NULL) {


		helper(['form', 'url']); //call helpers
		$validation = \Config\Services::validation();
		$data['title'] = 'Login';
		$data['info'] = $info;

		//valldate the form
		$validation->setRule('email', 'email', 'required|valid_email');
		$validation->setRule('pword', 'Password', 'required');

		//blank and fresh form, check if this is a post request
		if ($validation->withRequest($this->request)
			->run() === FALSE)//validate the request from form
		{
			if ($this->request->getMethod() === 'get') {

				$session = \Config\Services::session();
				$user = $session->get('user'); //set user for the session
				if (isset($user)) {
					if ($user->user_type == 'admin')
						header('Location: '.base_url('apps')); // go to appd
					else
						header('Location: '.base_url('dashboard')); // go to entry

				}


			} else
			{
				//post, came with errors
				$data['error'] = $validation->listErrors();
			}


			//load the form
			echo view('user/user_header');
			echo view('user/user_login_view', $data);
			echo view('user/user_footer');

		} else //form validated
		{
			$userModel = new UserModel();
			$loginDetails = array(

				'password' => $this->request->getPost('pword'),
				'email' => $this->request->getPost('email'),

			); //end array
			//validated check if record exists
			$user = $userModel->getWhere($loginDetails)->getFirstRow();
			if ($user == NULL)//incorrect login details
			{
				$data['error'] = "Incorrect Login credentials<br>";

				//load the form
				echo view('user/user_header');
				echo view('user/user_login_view', $data);
				echo view('user/user_footer');

			}//end if null

			else {
				//correct login details
				$session = \Config\Services::session();
				$session->set('user', $user); //set user for the session
				//set active applications
				$apps = new Apps();
				$apps = $apps->get(['status' =>'active']);//active only
				$session->set('nav_apps', $apps);//set active apps foe navigation
				    if (session('user')->user_type == 'admin')
					header('Location: '.base_url('art')); // go to appd
				else
					header('Location: '.base_url('art')); // go to entry



				//$this->load->view('portal_view', $data);
			}//end else successful
		}//end else
	}//end login

	public function edit() {

		$data;

		$user_id = session('user')->user_id; //get this user id

		$userModel = new UserModel();
		//get the user
		$validation = \Config\Services::validation();


		$validation->setRule('name', 'Name', 'required');

		$validation->setRule('email', 'Email', 'required|valid_email|is_unique[users.email,user_id, {user_id}]');

		$validation->setRule('phone_number', 'Phone Number', 'required');

		$validation->setRule('bvn', 'BVN', 'required|numeric|integer|exact_length[11]');

		$validation->setRule('address_country', 'Country', 'required');



		if ($validation->withRequest($this->request)

			->run() === FALSE)//validate the request from app

		{
			//validation failed, using get

			if ($this->request->getMethod() == 'get') {

				//fresh pt, blank

				//get the user
				$data['user'] = $this->getUser(['user_id' => $user_id]);

			} else

			{
				//post, came with errors
				$data['error'] = $validation->listErrors();

				//use this so we can return some error values and use it for set_value
				//or set_select
				$data['user'] = $this->request->getPost();

			}
			echo view('user_dash/user_dash_header');
			echo view('user/user_edit_view', $data);
			echo view('user_dash/user_dash_footer');

		} else

		{


			$user_details = [

				'name' => $this->request->getPost('name'),

				'email' => $this->request->getPost('email'),

				'phone_number' => $this->request->getPost('phone_number'),

				'address_street' => $this->request->getPost('address_street'),

				'address_lga' => $this->request->getPost('address_lga'),

				'address_state' => $this->request->getPost('address_state'),

				'address_country' => $this->request->getPost('address_country'),

				'bvn' => $this->request->getPost('bvn'),

				'user_id' => $user_id


			];


			//update

			$userModel->save($user_details);


			//redirect to the edit page, with a get

			header("Location:".base_url('user/edit/'));

		}//end else
	}//end edit user

	public function adminedit($user_id) {

		$data; //init data

		$userModel = new UserModel();
		//get the user
		$validation = \Config\Services::validation();

		$validation->setRule('user_type', 'User Role', 'required');

		if ($validation->withRequest($this->request)

			->run() === FALSE)//validate the request from app

		{
			//validation failed, using get
			if ($this->request->getMethod() == 'get') {

				//fresh pt, blank

				//get the user
				$data['user'] = $this->getUser(['user_id' => $user_id]);

			} else

			{
				//post, came with errors
				$data['error'] = $validation->listErrors();

				//use this so we can return some error values and use it for set_value
				//or set_select
				$data['user'] = $this->getUser(['user_id' => $user_id]);

			}
			echo view('user_dash/user_dash_header');
			echo view('user/admin_edit_view', $data);
			echo view('user_dash/user_dash_footer');

		} else

		{

			$user_details = [

				'user_type' => $this->request->getPost('user_type'),

				'user_id' => $user_id
			];


			//update

			$userModel->save($user_details);


			//redirect to the edit page, with a get

			header("Location:".base_url('user/adminedit/'.$user_id));

		}//end else
	}//end edit user


	public function viewall() {
		$data['users'] = $this->get();
		echo view('user_dash/user_dash_header');
		echo view('user/users_table', $data);
		echo view('user_dash/user_dash_footer');
	}//view users


	public function requestPassReset($user) {

		$reset_link = uniqid(random_int(53, 478483743));
		//get new link and save to database
		$pass_details = [

			'user_id' => $user['user_id'],

			'link' => $reset_link,

			'date_expired' => Time::now()->getTimestamp() + 30*60 //30 minutes

		];

		//save the event, it decides to update or insert
		$reset = new ResetPassModel();
		$reset->save($pass_details);

		$email = \Config\Services::email();

		$email->setFrom('info@circles.wishygifty.com', 'Rent Circles');
		$email->setTo($user['email']);


		$email->setSubject('You Requested for a Password Reset');
		$email->setMessage('Hello '. $user['name'].'<br><br>'.
			' You made a request to reset your password. <br><br>'.
			'Please click the link below to set a new password <br>'.
			'This link expires in 30 minutes.<br><br>'.
			'<a href ="'.site_url('user/newpassword/'.
				$user['user_id'].'/'.$reset_link).'"> Click here to set a new password</a><br><br>'.
			'Thank you');

		if ($email->send()) {
			//success
			$this->login("We just sent you an email. Please check your inbox for a link to reset your password");
		} else {
			echo "there was an error sending you an email";
		}
	}//end resetPassword

	public function emailReqPassReset() {
		//shows the password reset form for non logged in users
		$data = [];
		$validation = \Config\Services::validation();


		//valldate the form
		$validation->setRule('email', 'email', 'required|valid_email');

		//blank and fresh form, check if this is a post request
		if ($validation->withRequest($this->request)
			->run() === FALSE)//validate the request from form
		{
			if ($this->request->getMethod() === 'get') {
				//fresh form
			} else
			{
				//post, came with errors
				$data['error'] = $validation->listErrors();
			}


			//load the form
			echo view('user/user_header');
			echo view('user/email_form_reset_pass', $data);
			echo view('user/user_footer');



		} else //form validated
		{
			$email = $this->request->getPost('email');
			//get user from email
			$user = $this->getUser(['email' => $email]);
			//check if not null
			if ($user != NULL) {
				//request for a new password
				$this->requestPassReset($user); //
			} else {
				//user does not exist
				$data['error'] = "We did not find a user with that email please
			check and try again or register";
				//load password reset form
				//load the form
				echo view('user/user_header');
				echo view('user/email_form_reset_pass', $data);
				echo view('user/user_footer');
			}//

		}//end else
	}//end emailReqPassReset

	public function resetPassword() {
		//for logged in user
		$session = \Config\Services::session();
		$user = $session->set('user'); //get user for the session

		//request for a new password
		$this->requestPassReset($user);
	} //end resetPassword

	public function newPassword($user_id = NULL, $link = NULL) {
		//shows the password reset form for non logged in users

		//check if the link is still valid
		$resetModel = new ResetPassModel();
		$res = $resetModel->getWhere(['user_id' => $user_id, 'link' => $link])
		->getFirstRow('array');
		$expiry_time = $res['date_expired'];
		//current time
		$time_now = Time::now()->getTimestamp();

		//check if the time has expired

		if ($time_now < $expiry_time)//still within time
		{

			$validation = \Config\Services::validation();


			//valldate the form
			$validation->setRule('password', 'password', 'required');


			//fresh form or form with error
			if ($validation->withRequest($this->request)
				->run() === FALSE)//validate the request from form
			{
				//set the user_data collected from url
				$data['user_id'] = $user_id;
				$data['link'] = $link;

				if ($this->request->getMethod() === 'get') {
					//fresh form
					$data['info'] = "Set Your New Password";
				} else
				{
					//post, came with errors
					$data['error'] = $validation->listErrors();
				}


				//load the form
				echo view('user/user_header');
				echo view('user/new_password_form', $data);
				echo view('user/user_footer');

			} else //form validated
			{
				//get password
				$pass = $this->request->getPost('password');


				//update new password
				$userModel = new UserModel();

				$user_details = [

					'user_id' => $user_id,

					'password' => $pass
				];

				$userModel->save($user_details);

				//expire the link
				$link_details = [

					'id' => $res['id'],
					'date_expired' => $time_now
				];
				//update
				$resetModel->save($link_details);

				//go and login
				$this->login("Your password has been successfuly reset
			<br> Please log in");
			}//end if valid
		}//not expired
		else
		{
			//time expired
			//go and login
			$this->login("This link has expired. You can request for a
			new reset link");

		}//end else expired
	}//end newPassword

	public function logout() {
		$session = \Config\Services::session();
		$session->set('user', NULL); //unset user


		$session->destroy(); //destroy the session
		$this->login();


	}//logout


	public function dashboard() {

		echo view('user_dash/user_dash_header');
		echo view('user_dash/user_dash');
		echo view('user_dash/user_dash_footer');
	}

	public function getUser($userDetails) {
		//returns one user
		$userModel = new UserModel();

		//validated check if record exists
		$user = $userModel->getWhere($userDetails)->getFirstRow('array');
		return $user;
	}


	public function get($condition = NULL) {
		$userModel = new UserModel();

		//validated check if record exists
		$user = $userModel->getWhere($condition)->getResultArray();
		return $user;
	}

}//end class