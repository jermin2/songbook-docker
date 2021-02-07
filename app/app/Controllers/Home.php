<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
    $data['heading'] = "SongBook"; //Capitalize the first eltter
    
    echo view('templates/header', $data);
    echo view('song/index', $data);
    echo view('templates/footer', $data);
	}

	//--------------------------------------------------------------------

}
