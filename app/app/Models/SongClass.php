<?php namespace App\Models;

use \stdClass;

  class SongClass {
  
    //Properties
    public $lyrics;
    public $meta_data;
    public $id;
    public $songNum;
  
  //GLOBAL VARIABLES
  private $VERSE = 1;   //For use when verse numbers are not specificed
  

        // Constructor
    public function __construct( $lyric_text){
      //create class
      $lyrics = new stdClass;
      
      //Create empty meta_data
      $this->meta_data = new stdClass;
      $this->meta_data->title = "no Title";
      $this->meta_data->author = "no Author";
      
      
      $this->lyrics = new stdClass;
      
      
    
      //load the rest of the song
      $this->parse_lyrics($lyric_text);
    }
    
    public function setMeta_data($meta){
      $this->meta_data = $meta;
    }
    
    public function setId($id)
    {
      $this->id = $id;
    }
    public function setNum($songNum)
    {
      $this->songNum = $songNum;
    }    

    //Used to find meta data (at the front of the song
    private function get_directive_param($text, $directive){
      $pos = strpos ( $text, $directive);
      if($pos !== false){
        $startpos = $pos + strlen($directive); // add two for the ": "
        $end_pos = strpos( $text, "}", $pos);
        return substr($text, $startpos, $end_pos-$startpos);
      }
      return false;
    }
    
    public function parse_lyrics($lyric_text)
    {
      //Handle directives
      if(!isset($this->meta_data->title))
        $this->get_directive_param($lyric_text, "{title: ");
      if(!isset($this->meta_data->author))
        $this->meta_data->author = $this->get_directive_param($lyric_text, "{author: ");
      if(!isset($this->meta_data->source))
        $this->meta_data->source = $this->get_directive_param($lyric_text, "{source: ");
      
      $this->lyrics->verses = array();
      $verse_num = 0;
      
      
      //split on either {verse or {chorus or {comment
      $verses = explode("{", $lyric_text);
      
      foreach($verses as $verse){
        //If there is nothing in the verse (can happen depending on white space positioning and curly bracket
        if(strlen(trim($verse)) == 0) continue;
        
        //Split by the closing curly bracket } to determine what kind of verse this is
        $verse_text = explode("}", $verse);
        
        if( (strpos($verse_text[0], "title")  !== false) ||
            (strpos($verse_text[0], "source") !== false) ||
            (strpos($verse_text[0], "author") !== false)  )
          continue;
        
        //if its a comment
        if(strpos($verse_text[0], "comment") !== false){
          
          
          if($verse_num !=0 )
          {
            $verse_num--;
          }
          
          //Create a new verse object
          if(!isset($this->lyrics->verses[$verse_num]))
            $this->lyrics->verses[$verse_num] = new stdClass();
          
          //Create a new array for the lines in the verse
          if(!isset($this->lyrics->verses[$verse_num]->lines))
            $this->lyrics->verses[$verse_num]->lines = array();

          $line = new stdClass;
          
          //Extract the comment
          $comment = substr($verse_text[0],9, strlen($verse_text[0])-9);
          $line->comment = $comment;
          $this->lyrics->verses[$verse_num]->lines[] = $line;
          
          if(!isset($this->lyrics->verses[$verse_num]->directive))
          {
            $directive = new stdClass;
            $directive->type = "comment";
            $directive->param = $comment;

            $this->lyrics->verses[$verse_num]->directive = $directive; 
          }
          
          //Since it reads a comment as a verse, the rest of the verse/chorus gets picked up, so merge it with the previous verse
          $temp_verse = $this->parse_verse(trim($verse_text[1]));
          $this->lyrics->verses[$verse_num]->lines = array_merge($this->lyrics->verses[$verse_num]->lines, $temp_verse->lines);
          //array_push($this->lyrics->verses[$verse_num]->lines , $temp_verse->lines);
          $verse_num++;
          
          continue;
        }
        
        //If $verse_text[1] doesn't exist, then it means no verse directive
        if(!isset($verse_text[1]))
        {
          $this->lyrics->verses[$verse_num] = $this->parse_verse(trim($verse_text[0]));
        }
        else
          $this->lyrics->verses[$verse_num] =  $this->parse_verse(trim($verse_text[1]));
        
        //Add the directive
        $this->lyrics->verses[$verse_num++]->directive = $this->parse_verse_type(trim($verse_text[0]));


        //Handle verse number and chorus
          //check for verse. Verses can either appear as {verse: 1} or {verse}
        //ignore this line if it was a comment

      }
    }
    
    public function parse_verse_type($verse_text)
    {
      $directive = new stdClass;
      $directive->type = false;
      $directive->param = "";
      
      //will either get chorus verse or verse: 1 or comment
      //check for chorus
      if (strpos($verse_text, "chorus") !== false)
      {
        $directive->type = "chorus";
        return $directive;
      }
      
      //check for verse
        //check for verse number
      if (strpos($verse_text, "verse") !== false)
      {
        $directive->type = "verse";

        //Check if it contains ':'
        if (stripos($verse_text, ":") !== false){
          //grab the parameter and store
          $param = explode(":", $verse_text)[1];
          $directive->param = $param;
        } else {
          $directive->param = $this->VERSE;
          $this->VERSE++;
        }
      }
      //if its a comment
      if (strpos($verse_text, "comment") !== false)
      {
        $directive->type = "comment";
        $param = explode(":", $verse_text)[1];
        $directive->param = $param;
        return $directive;
      }
      
      return $directive;
    }
    

    
    function getChordsheet(){
      return $chordsheet;
    }
    
    function newChordLyricPair($chord, $lyric)
    {
      $chordLyricPair = new stdClass;
      $chordLyricPair->chord = $chord;
      $chordLyricPair->lyric = strlen($lyric)< 2? $lyric." " : $lyric; //The chord has to be matched with lyrics, so if there are no lyrics, make some up
      
      return $chordLyricPair;
    }
    
    //Verse and chorus are treated the same for now. Or a chorus is a special verse
    function parse_verse($verse_text)
    {
      $verse = new stdClass;
      $verse->lines = array();
      $x = 0;
      
      $line_texts = explode("\n", $verse_text);
      foreach($line_texts as $line_text){
        if(strlen(trim($line_text))==0) continue;
        $verse->lines[$x++] = $this->parse_line($line_text);
      }
      
      return $verse;
    }
    
    public function parse_line($line_text)
    {
      $line = new stdClass;
      $line->chordLyricPair = array();
      $line->hasChords = false;
      
      //The chordLyricPair index
      $x = 0;
      
      //check to see if line starts with {
      if($line_text[0] == "{")
        //its a directive
        {
        }
      
      //otherwise its a chordLyricPair
      $explode_text = explode("[", $line_text);
      foreach($explode_text as $text){
        
        //If the string is empty (happens if the chord is at the start of the verse)
        if(strlen($text) == 0) continue;
        
        //Check if there is an ] bracket. If there isn't, there is no chord, so just do the lyric
        $explodeChordLyric = explode("]", $text);
        
        if(count($explodeChordLyric) > 1){
          //If there is a chord
          $line->chordLyricPair[$x] = $this->newChordLyricPair($explodeChordLyric[0], $explodeChordLyric[1]);
          $line->hasChords = true;
        }
        else {
          $line->chordLyricPair[$x] = $this->newChordLyricPair("", $explodeChordLyric[0]);
        }
        $x++;
        
      }
      
      //$line->chordLyricPair[0] = $this->newChordLyricPair("A", $line_text);
      return $line;
    }
    
    
    function addToLine($chordLyricPair)
    {
      $line[0] = newChordLyricPair("A", "Somewhere over");
      $line[1] = newChordLyricPair("B", "Way up high");
      
    function getChordLyricPair()
    {
      $chordLyricPair;
    }
  }
  
      
    public function parse_song($line_text)
    {
      //Read each line
      $lines = explode ("\n", $line_text);
      foreach($lines as $line)
      {
        parse_line($line); 
      }
    }
  }
?>