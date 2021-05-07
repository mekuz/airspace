<?php namespace App\Controllers;







use App\Models\ArtModel;





use CodeIgniter\Controller;


class Art extends BaseController

{
	
	protected $artModel;

	protected $session;

	protected $validation;

	protected $user_id;

	public function __construct() {

		//model
		$this->artModel = new artModel();

		//session
		$this->session = \Config\Services::session();
		//load art and validation helpers

		helper(['form', 'url']);

		$this->validation = \Config\Services::validation();

		//check if user is logged in

		    


		
	}

	public function index($page = 0) {

		$data['start'] = $page *20; //index for serial number
		//get all your arts
		$data['arts'] = $this->get();
	

		//show the art view
		
		echo view('user_dash/user_dash_header');

		echo view("art/table_view", $data); //show the arts

		echo view('user_dash/user_dash_footer');

	}//end method index

	public function edit($art_id = NULL) {


		//echo $art_id;

		$this->validation->setRule('name', 'Name', 'required');

		$this->validation->setRule('description', 'Description', 'required');
		
		$this->validation->setRule('short_description', 'Short Description', 'required');

	

		if ($this->validation->withRequest($this->request)
			->run() === FALSE)//validate the request from art
		{

			//validation
			if ($this->request->getMethod() == 'get') {

				//using the get art

				//fresh art, blank
				
				if ($art_id == NULL) {

					$data['art_id'] = NULL;
					$data['art'] = NULL;

				} else {

					//display an exiting art
					$data['art_id'] = $art_id;
					$data['art'] = $this->getById($art_id);

				}

			} else

			{

				//post, came with errors

				//echo "posted with errors";

				$data['error'] = $this->validation->listErrors();

				//use this so we can return some error values and use it for set_value

				//or set_select
				$data['art_id'] = $art_id;

				$data['art'] = $this->request->getPost();
			}




			echo view('user_dash/user_dash_header');

			echo view('art/art_edit_view', $data);

			echo view('user_dash/user_dash_footer');

		} else

		{
			//valid so update or insert
			$art_details = [
				'name' => $this->request->getPost('name'),
				'description' => $this->request->getPost('description'),
				'short_description' => $this->request->getPost('short_description'),
				'sign' => $this->request->getPost('sign'),

				'id' => $art_id
			];
			
			//img
			$file = $this->request->getFile('img');
			if ($file->getName())
			{
				// Generate a new secure name
				$name = $file->getRandomName();
				// Move the file to it's new home
				$file->move(ROOTPATH.'uploads/arts', $name);
				$art_details['img'] =$name;
			}//end if files
			
			//audio
			$file = $this->request->getFile('audio');
			if ($file->getName())
			{
				// Generate a new secure name
				$name = $file->getRandomName();
				// Move the file to it's new home
				$file->move(ROOTPATH.'uploads/arts', $name);
				$art_details['audio'] =$name;
			}//end if files
			
			//video
			$file = $this->request->getFile('video');
			if ($file->getName())
			{
				// Generate a new secure name
				$name = $file->getRandomName();
				// Move the file to it's new home
				$file->move(ROOTPATH.'uploads/arts', $name);
				$art_details['video'] =$name;
			}//end if files
			
			
			//save the art, it decides to update or insert
			$this->artModel->save($art_details);

			//get id as insertId(new) or submitted ID
			$art_id = $art_id ? $art_id :$this->artModel->insertID();

			//redirect to the art, but this time do a get
			$data['art_id'] = $art_id;

			header("Location:".base_url('art/edit/'.$art_id));





		}//end else

	}//end edit arts

	public function all()
	{
	    
		//get all your arts
		$data['arts'] = $this->get();
	

		//show the art view
		
		echo view('user_dash/user_dash_header');

		echo view("art/all_arts_view", $data); //show the arts

		echo view('user_dash/user_dash_footer');
	}//end finciton all
	
	public function view($art_id)
	{
	    
		//get all your arts
		$data['art'] = $this->getById($art_id);
	

		//show the art view
		
		echo view('user_dash/user_dash_header');

		echo view("art/single_view", $data); //show the arts

		echo view('user_dash/user_dash_footer');
	}//end finciton all
	
	public function hit($art_id){
	    //for analytics, show how many times an art work was queried with the scanner
	    $art = $this->getById($art_id);
	    $art['hits'] = $art['hits'] + 1;//increase the hit
	    
	    //save the art
	    $this->artModel->save($art);
	    
	}//end function hits
	
	public function chart(){
        //get all art	  
	    $data['arts'] = $this->get();
	    //load view
	    echo view('user_dash/user_dash_header');

		echo view("art/chart_view", $data); //show the arts

		echo view('user_dash/user_dash_footer');
	}//end chart function

	public function get($condition = NULL) {

		//get all art

		return $this->artModel->getWhere($condition)->getResultArray();

	}//end get Apps



	public function getById($id) {

		//get all art

		return $this->artModel->getWhere(['id' => $id])

		->getFirstRow('array');

	}











}//end class