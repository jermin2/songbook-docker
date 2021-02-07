<?php namespace App\Models;
use App\Models\SongClass;
use CodeIgniter\Model;
use \stdClass;

class SongModel extends Model {
  
  protected $table = 'song_table';
  protected $allowedFields = ['title', 'author', 'source', 'lyrics'];
  
  
  public function getSongRaw($song_id)
  {
    $result = $this->asArray()
                ->where(['id' => $song_id])
                ->first();   
    return $result;
    
    
    
  }
  public function getSong($song_id)
  {
    $result = $this->asArray()
                ->where(['id' => $song_id])
                ->first();
                
    $song = new SongClass($result['lyrics']);
    $meta_data = new stdClass;
    $meta_data->title = $result['title'];
    $meta_data->author = $result['author'];    
    $meta_data->source = $result['source']; 
    $song->setMeta_data($meta_data);    
    return $song;
  }
  
  public function getSongs($song_ids)
  {
    $result = $this->asArray()
                ->whereIn('id', $song_ids)
                ->findAll();
    
    $songs = [];
    foreach ($result as $song)
    {
      $newSong = new SongClass($song['lyrics']);
      $newSong->setId($song['id']);
      $meta_data = new stdClass;
      $meta_data->title = $song['title'];
      $meta_data->author = $song['author'];    
      $meta_data->source = $song['source']; 
      $newSong->setMeta_data($meta_data); 
      
      
      
      
      $songs[$song['id']] = $newSong;
    }
                
    return $songs;
  }
  
  public function getList()
  {
    return $this->asArray()
                ->select('id, title')
                ->orderBy('title', 'ASC')
                ->findAll();
  }
}
?>