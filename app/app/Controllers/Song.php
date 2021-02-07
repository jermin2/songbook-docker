<?php namespace App\Controllers;
use App\Models\SongModel;
use App\Controllers\PDFCreator;
use CodeIgniter\Controller;

class Song extends Controller 
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
    $model = new SongModel();
    $data['songs'] = $model->getList();
		$data['heading'] = '';
    
    echo view('templates/header', $data);
    echo view('song/index', $data);
    echo view('templates/footer', $data);
	}
  
  public function view($songid = null)
  {
    $model = new SongModel();
    $data['song'] = $model->getSong($songid);
    $data['id'] = $songid;
    $data['heading'] = $data['song']->meta_data->title;
    
    echo view('templates/header', $data);
    echo view('song/view', $data);
    echo view('templates/footer', $data);    
    
  }
  
  public function createPDF($songid = null)
  {
    $model = new SongModel();
    $data['song'] = $model->getSong($songid);
    $data['title'] = 'Song Book';
    $data['id'] = $songid;
    
    include ("PDFCreator.php");
    $PDFCreator = new PDFCreator();
    $PDFCreator->createSinglePDF($data['song']);
    
  } 

  public function edit($songid = null)
  {
    helper('form');
    $model = new SongModel();
    
    
    
    if (! $this->validate([
      'title' => 'required|min_length[3]|max_length[255]',
      'lyricfield' => 'required'
      ]))
    {
      $data['song'] = $model->getSongRaw($songid);
      $data['id'] = $songid;
      $data['title'] = $data['song']['title'];
      $data['author'] =$data['song']['author'];
      $data['source'] =$data['song']['source'];
      $data['lyrics'] =$data['song']['lyrics'];
      $data['type'] = "edit";
      
      $data['validation'] = $this->validator;
      
      echo view('templates/header', ['heading' => 'Edit a song']);
      echo view('song/load', $data);
      echo view('templates/footer');
    }
    else
    {
      $title = "{title: " . $this->request->getVar('title') . "}\n";
      $author = "{author: " . $this->request->getVar('author') . "}\n";
      $source = "{source: " . $this->request->getVar('source') . "}\n";
      
      $id = $this->request->getVar('id');
      
      //Do some manipulation on the lyrics to convert \n to linebreak
      $lyrics = $this->request->getVar('lyricfield');
      $lyrics = str_replace('\n', "\n", $lyrics);
      
      
      $data = [
        'id'      => $this->request->getVar('id'),
        'title'   => $this->request->getVar('title'),
        'author'   => $this->request->getVar('author'),
        'source'   => $this->request->getVar('source'),
        'lyrics'  => $lyrics
      ];        
      
      $model->save($data);
      
      $this->view($id);
    }

  }

  public function load()
  {
    helper('form');
    $model = new SongModel();

    if (!$this->validate([
      'title' => 'required',
      'lyricfield' => 'required'
      ],
      [ //Errors
        'title' => [ 'required' => 'Need a title',
        ],
        'lyricfield' => [ 'required' => 'Need lyrics',
        ]
      ]))
      {
      
        $data['response'] = "";
        $data['source'] = $this->request->getVar('source');;
        $data['author'] = $this->request->getVar('author');;
        $data['lyrics'] = $this->request->getVar('lyricfield');;
        $data['id'] = "";
        $data['type'] = "load";
        $data['title'] = $this->request->getVar('title');
        
        $data['validation'] = $this->validator;   
        
        echo view('templates/header', ['heading' => 'Load a song']);
        echo view('song/load', $data);
        echo view('templates/footer');
      }
      else 
      {
        $data = [

        'title'   => $this->request->getVar('title'),
        'author'   => $this->request->getVar('author'),
        'source'   => $this->request->getVar('source'),
        'lyrics'  => $this->request->getVar('lyricfield'),     
      ];

      $model->save($data);
      
      echo view('templates/header', ['heading' => 'Success']);
      echo view('song/success');
      echo view('templates/footer');
      }
  }
  
  //Hand AJAX request to load HTML from songbase and hymnal
  public function loadurl()
  {
    
    $response_array['status'] = 'success'; 
    
    if($this->request->isAJAX())
    {
      $json = $this->request->getJSON();
      $targeturl = $json->targeturl;
      
      $response = file_get_contents($targeturl);
      
      if(strpos($targeturl, "songbase.life") != false)
      {

        //For the title &quot;title&quot;:&quot;(.*?)&quot;
        $pattern = '/(?:&quot;title&quot;:&quot;)(.*?)&quot/';
        preg_match($pattern, $response, $matches);
        $title = trim(html_entity_decode($matches[1]));
        $response_array['title'] = $title;
        
        $SEARCH_STRING = '&quot;lyrics&quot;:&quot;';
        $startpos = strpos($response, $SEARCH_STRING) + strlen($SEARCH_STRING);
        $endpos = strpos($response, '&quot;}', $startpos);
        
        
        $response = substr($response, $startpos, $endpos-$startpos);
        
        //Comment Pattern
        // (^|\\n) - Must be start of doc, or start of linebreak
        // (.*?) - match everything except linebreak
        $pattern = '/(?:^|\\\\n)#(.*?)\\\\n/';
        $replace = '{comment: ${1}}\\\\n';
        $response = preg_replace($pattern, $replace, $response);
        
        //Verse Pattern
        $pattern = "/(?:^|\\\\n)([1-9])\\\\n/";
        $replace = '\n{verse: ${1}}\n';
        $response = preg_replace($pattern, $replace, $response);
        
        //Chorus Pattern
        $pattern = '/(\\\\n|\\\\t)\\\\n  /';
        $replace = '\n\n{chorus}\n';
        $response = preg_replace($pattern, $replace, $response);
        
        //Song base has two spaces in each line of the chorus. Remove these
        $pattern = '/\\\\n  /';
        $replace = "\n";
        $response = preg_replace($pattern, $replace, $response);

        $response = trim(str_replace('\n', "\n", $response));
        
        
      }
      else if(strpos($targeturl, "hymnal.net") != false)
      {
        
       
        //For the title (?: means don't include in matches. (.*?) means get everything
        $pattern = ' /(?:\<h1 class="text-center">)((\s|.)*?)(?:\<\/h1>)/';
        preg_match($pattern, $response, $matches);
        $title = trim(html_entity_decode($matches[1]));
        $response_array['title'] = $title;
        
        $SEARCH_STRING = 'hymn-content">';
        $startpos = strpos($response, $SEARCH_STRING) + strlen($SEARCH_STRING);
        $endpos = strpos($response, '</table', $startpos);
        $response = substr($response, $startpos, $endpos-$startpos);
        
         //Verse Pattern
        $pattern = '/\<div class="stanza-num">([1-9])\<\/div>/';
        $replace = '{verse: ${1} }\n';
        $response = preg_replace($pattern, $replace, $response);       

         //Chorus Pattern
        $pattern = '/\<td class="chorus">/';
        $replace = '{chorus}\n';
        $response = preg_replace($pattern, $replace, $response);  
 

 
        //Deal with white space
        $pattern = '/\s{2,}/';
        $replace = '';
        $response = preg_replace($pattern, $replace, $response); 
        
        //Deal with new lines
        $pattern = '/\<\/tr>/';
        $replace = "\n\n";
        $response = preg_replace($pattern, $replace, $response);         
        
        //Deal with new lines
        $pattern = '/(\<br\/>)|(\\\\n)/';
        $replace = "\n";
        $response = preg_replace($pattern, $replace, $response); 

        //Deal with remaining tabs
        $pattern = '/\<(.*?)>/';
        $replace = '';
        $response = preg_replace($pattern, $replace, $response); 
        
        //Get rid of any extra space at the start and the end
        $response = trim($response);
        //If it doesn't start with verse, then put verse
        $versepos = strpos($response, "{verse");
        if( $versepos === false | $versepos > 0 ){
          $response = "{verse}\n".$response;
        }
      }
      
      $response = html_entity_decode($response);
      $response = str_replace('—', '-', $response);
      $response_array['html'] = $response;
      echo json_encode($response_array);
    
    }
    
    
    
  }

    
}
