<?php namespace App\Controllers;

use App\Models\SongModel;
use App\Models\BookModel;
use CodeIgniter\Controller;
use App\Controllers\PDFCreator;

class Book extends Controller 
{

	
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
    $model = new BookModel();
    $data['books'] = $model->getList();
		$data['heading'] = 'Books';
    
    echo view('templates/header', $data);
    echo view('book/index', $data);
    echo view('templates/footer', $data);
	}

  public function view($bookid = null)
  {

    $song_model = new SongModel();
    $data['songs'] = $song_model->getList();
    $book_model = new BookModel();
    $data['books'] = $book_model->getList();
    $data['book'] = $book_model->getBook($bookid);
    $data['id'] = $bookid;
    $book = $book_model->getBook($bookid);
    $data['name'] = $book['name'];
    //$data['songids'] = $book['songids'];
    $data['songids'] = explode(",",$book['songids']);
    $data['params'] = $book['params'];


    echo view('templates/header', ['heading' =>  $book['name']]);
    echo view('book/create', $data);
    echo view('templates/footer');
  }

  public function create()
  {
    helper('form');
    
    $book_model = new BookModel();
    $data['books'] = $book_model->getList();
    
    if (! $this->validate([
      'name' => 'required|min_length[3]|max_length[255]',
      ]))
    {

      echo "name is not long enough ";
    }
    else
    {
      $title = "{name: " . $this->request->getVar('name') . "}\n";
      
      $song_model = new SongModel();
      $data['songs'] = $song_model->getList();

      $book_model->save([
        'name' => $this->request->getVar('name')
      ]);

      $id = $book_model->getInsertID();

      $data['id'] = $id;
      $data['name'] = $this->request->getVar('name');
      //Should be a redirect
      echo view('templates/header', ['heading' => $this->request->getVar('name')]);
      echo view('book/create', $data);
      echo view('templates/footer');
      //echo view ('song/success');
    }
  }
  
  //AJAX Response to creating a PDF from creating book 
  public function createPDF()
  {
 
    $response_array['status'] = 'success'; 
    
    if($this->request->isAJAX())
    {
      $json = $this->request->getJSON();
      $songids = $json->values;
      
      $model = new SongModel();
      $songlist = $model->getSongs($songids);
      
      $PDFCreator = new PDFCreator();
      $params = $json->params;
      
      $response_array['param'] = $params->FONT_SIZE;
      $response_array['param2'] = $params->CHORD_SIZE;
      $response = $PDFCreator->create($songlist, $songids, $params);
      $base64 = chunk_split(base64_encode($response));
      $response_array['pdf'] = $base64;
      $response_array['q'] = $songids;
      echo json_encode($response_array);
    
    }
    
  }   

  /*
  Save the book into the database
  @name - The name of the Book
  @songids - a list of ids as shown under the chosen songs column in order, including page break and column breaks
  @params - the current saved params
  */
  public function saveBook()
  {
    $response_array['status'] = 'success'; 
    
    if($this->request->isAJAX())
    {
      $json = $this->request->getJSON();
      $songids = $json->values;
      $params = $json->params;
      
      $response_array['message'] = "hi";
      $response_array['params'] = $params;
      
      $model = new BookModel();
      $data['name'] = $json->name;
      $data['songids'] = implode(",", $songids);
      $data['params'] = json_encode($params);
      $data['id'] = $json->id;
      $model->save($data);

      $response_array['data'] = $data;

      echo json_encode($response_array);
    
    }

  }

  public function loadBook()
  {

    $response_array['status'] = 'success'; 
    
    if($this->request->isAJAX())
    {
      $json = $this->request->getJSON();
      $songids = $json->values;
      $params = $json->params;
      
      $response_array['message'] = "hi";
      // $response_array['params'] = $params;
      
      $model = new BookModel();
      
      $book = $model->getBook($json->id);
      $response_array['name'] = $book['name'];
      $response_array['songids'] = explode(",",$book['songids']);
      $response_array['params'] = json_decode($book['params']);

      echo json_encode($response_array);
    
    }
  }
    
}
