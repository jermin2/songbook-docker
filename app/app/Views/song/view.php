<style>
 

  div.line {
    display: block;
  }

  span.line-text {
    vertical-align: bottom;
  }

  span.chord {
    position: relative;
    padding-top: 17px;
    top: -17px;
    display:inline-block;
    width: 0;
    overflow:visible;
    font-weight:bold;
    font-size: 0.8em;
    font-family:Arial, Helvetica, sans-serif;
    white-space: nowrap;
  }
  
  [uncopyable-text]::after {
    content: attr(uncopyable-text);
  }
  
  .verse-number {
    margin-left: -25px;
    position: absolute;
    font-weight:bold;
    font-family:Arial, Helvetica, sans-serif;
  }
  
  .lyrics {
    margin-left: 25px;
    margin-bottom: 30px;
    display: inline-block;
  }
  
  .verse {
    padding-bottom: 10px;
  }
  
  .chorus {
    margin: 0 0 10px 25px;
  }
    
  .application-container {
    max-width: 800px;
    padding: 20px 30px 20px 30px;
    margin: auto;
  }

	</style>

  <div class="song-container text-center">
    <div class="lyrics text-left">
	
	<?php

		echo '<div class="meta author">';
    echo $song->meta_data->author;
    echo '</div><br />';
    
    echo '<div class="meta source"><i>';
    echo $song->meta_data->source;
    echo '</i></div>';

	foreach($song->lyrics->verses as $verse){
        
		echo '<div class="verse">';
    if($verse->directive->type=="verse") 
      echo '<div class="verse-number">', $verse->directive->param , '</div>';
    
    if($verse->directive->type=="chorus") echo '<div class="chorus">';
    foreach($verse->lines as $line){
      echo '	<div class="line"> <span class="line-text">';
      
      if(isset($line->comment))
      { 
        echo '<span class="comment"><i>',$line->comment,'</i></span>';
      } else
      foreach($line->chordLyricPair as $item){
      //if( isChordLyricPair(item) ){

        echo '<span class="chord" uncopyable-text="';
        echo   '">', $item->chord, '</span>';
        echo $item->lyric;

      }
      echo '</span>';
      echo '</div>'; //close line
    }
    if($verse->directive->type=="chorus") echo '</div>';
    echo '</div>'; //close paragraph
		}
	?>
	
  </div>
  <br />
<a href="<?='/song/edit/'.$id ?>" class="btn btn-secondary">Edit</a>
<a href="<?='/song/createPDF/'.$id ?>" class="btn btn-primary">Download to PDF</a>
<br />
