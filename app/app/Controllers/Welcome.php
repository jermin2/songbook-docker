<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('Song_model');
		$this->load->helper('url_helper');
    
    include APPPATH . 'third_party/TCPDF/TCPDF.php';
	}
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		
		$data['song'] = $this->Song_model->get_song($this);
		$data['title'] = 'This is the title';
		
		$this->load->view('index', $data);
	}
  
  public function song()
  {
    $this->load->model('Song_model');
    
		$data['song'] = $this->Song_model->get_songdb(1);
		
		$this->load->view('view_song', $data);    
    
  }
 
}
