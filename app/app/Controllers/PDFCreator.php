<?php namespace App\Controllers;
use \TCPDF;
use App\Models\SongClass;

class PDFCreator {

  public $pdf = "";
  
  //Create Single PDF
  public function createSinglePDF($song)
  {
  
  // create new PDF document
  $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

  // set document information
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor('Nicola Asuni');
  $pdf->SetTitle('TCPDF Example 002');
  $pdf->SetSubject('TCPDF Tutorial');
  $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

  // remove default header/footer
  $pdf->setPrintHeader(false);
  $pdf->setPrintFooter(false);

  // set default monospaced font
  $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

  // set margins
  $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

  // set auto page breaks
  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

  // set image scale factor
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

  // set some language-dependent strings (optional)
  if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
      require_once(dirname(__FILE__).'/lang/eng.php');
      $pdf->setLanguageArray($l);
  }

  // ---------------------------------------------------------

  define( "FONT_SIZE" , 12);
  define ("FONT_STYLE" , 'times');
  define ("CHORD_SIZE" , 10);
  
  define ("LYRIC_STYLE", '');
  define ("CHORD_STYLE", '');
  define ("INDEX_STYLE", 'B');
  define ("COMMENT_STYLE", 'I');
  // set font
  //LYRIC FONT
  $pdf->SetFont(FONT_STYLE, LYRIC_STYLE, FONT_SIZE);
  //CHORD FONT
  //$pdf->SetFont(FONT_STYLE, CHORD_STYLE, CHORD_SIZE);
  //INDEX FONT
  //$pdf->SetFont(FONT_STYLE, INDEX_STYLE, FONT_SIZE);
  //COMMENT FONT
  //$pdf->SetFont(FONT_STYLE, COMMENT_STYLE, FONT_SIZE);

  //Set format spacing
  //Sample CHORD height
  $pdf->SetFont(FONT_STYLE, CHORD_STYLE, CHORD_SIZE);
  $chord_height =  $pdf->getStringHeight(0, "Sample string");
  
  //Sample LYRIC height
  $pdf->SetFont(FONT_STYLE, LYRIC_STYLE, FONT_SIZE);
  $line_height = $pdf->getStringHeight(0, "Sample string");
  $verse_index_tab = $pdf->getStringWidth("00. ");
  $chorus_tab = $pdf->getStringWidth("AA");
  
  // add a page
  $pdf->AddPage();
  
  // set some text to print
  $txt = "<<<EOD
  TCPDF Example 002
  
  Default page header and footer are disabled using setPrintHeader() and setPrintFooter() methods.
  EOD";
  
  // print a block of text using Write()
  //$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

  $pdf->Write(0, $song->meta_data->title, '', 0, 'C', true, 0, false, false, 0);
  $pdf->Write(0, $song->meta_data->author, '', 0, 'C', true, 0, false, false, 0);
  $pdf->Write(0, $song->meta_data->source, '', 0, 'C', true, 0, false, false, 0);
  
  
  foreach($song->lyrics->verses as $verse)
  {
    
/*     if($verse->directive->type=="comment")
    {
      $pdf->SetFont(FONT_STYLE, COMMENT_STYLE, FONT_SIZE);
      $pdf->Write(0, $verse->directive->param);
      $pdf->SetFont(FONT_STYLE, LYRIC_STYLE, FONT_SIZE);
    } */
    
    //Write the verse number
    if($verse->directive->type=="verse")
    {
      $currentX = $pdf->GetX();
      $currentY = $pdf->GetY();
      
      if($verse->lines[0]->hasChords == true)
      {
        $pdf->setY( $pdf->getY() + $chord_height);
      }
      $pdf->SetX($currentX - $verse_index_tab);
   
      $pdf->SetFont(FONT_STYLE, INDEX_STYLE, FONT_SIZE);
      $pdf->Write(0, $verse->directive->param);
      $pdf->SetFont(FONT_STYLE, LYRIC_STYLE, FONT_SIZE);
      $pdf->SetXY($currentX , $currentY);
      
    }
    
    //Set a flag if its the chorus (so we can indent)
    $isChorus = false;
    if($verse->directive->type=="chorus") {
      //$pdf->Write(0, "(Chorus)\n");
      $isChorus = true;
      
    }
       
    foreach($verse->lines as $line) 
    {
      //If there are chords in this verse/line, move down to make room for it
      if(isset($line->hasChords) && $line->hasChords== true)
        $pdf->setY($pdf->getY() + $chord_height);
      
      //If its a chorus, tab it
      if($isChorus == true){
        $pdf->setX($pdf->getX() + $chorus_tab);
      }
       
      //Write any comments
      if(isset($line->comment)) {
        $pdf->SetFont(FONT_STYLE, COMMENT_STYLE, FONT_SIZE);
        $pdf->WriteHTML( $line->comment, false);
        //$pdf->Write(0, $line->comment);
        $pdf->SetFont(FONT_STYLE, LYRIC_STYLE, FONT_SIZE);
      }
      else
      {
        foreach($line->chordLyricPair as $item)
        {
          //Write the Chord first
            //Save the position so we can come back to it
          $currentX = $pdf->GetX();
          $currentY = $pdf->GetY();
            //We write the chord over the word first
          $pdf->SetXY($currentX , $currentY - $chord_height);
          $pdf->SetFont(FONT_STYLE, CHORD_STYLE, CHORD_SIZE);
          $pdf->Write(0, $item->chord);
          //Remember to reset the font to the lyric font
          $pdf->SetFont(FONT_STYLE, LYRIC_STYLE, FONT_SIZE);
          
            //Then come back to the lyric to write it
          $pdf->SetXY($currentX , $currentY);
          if(!empty($item->lyric)){
            $pdf->Write(0, $item->lyric);
          }
        }
      }
      
      //Write new line end of each line
      $pdf->Write(0, "\n");

    }
    
    //Write new line end of each verse
    $pdf->Write(0, "\n");
    
  }
       
  // ---------------------------------------------------------

  //Close and output PDF document
  ob_end_clean();
  $pdf->Output('example.pdf', 'I');
  exit();

  //============================================================+
  // END OF FILE
  //============================================================+
  }
  
  private function writeComment($comment)
  {
    $pdf = $this->pdf;
    $pdf->SetFont(FONT_STYLE, COMMENT_STYLE, FONT_SIZE);
    $pdf->WriteHTML( "<div>".$comment."</div>", false, false, true, true);
    //$pdf->Write(0, $comment);
    $pdf->SetFont(FONT_STYLE, LYRIC_STYLE, FONT_SIZE);  
  }
  
  private function writeIndex($index)
  {
    $pdf = $this->pdf;
    $pdf->SetFont(FONT_STYLE, INDEX_STYLE, FONT_SIZE);
    $pdf->Write(0, $index);
    $pdf->SetFont(FONT_STYLE, LYRIC_STYLE, FONT_SIZE);
  }
  private function writeChord($chord)
  {
    $pdf = $this->pdf;
    $pdf->SetFont(FONT_STYLE, CHORD_STYLE, CHORD_SIZE);
    $pdf->Write(0, $chord);
    $pdf->SetFont(FONT_STYLE, LYRIC_STYLE, FONT_SIZE);
  }  
  private function writeSongNum($songNum)
  {
    $pdf = $this->pdf;
    $pdf->SetFont(FONT_STYLE, SONGNUM_STYLE, SONGNUM_SIZE);
    $pdf->Write(0, $songNum);
    $pdf->Write(0, "\n");
    $pdf->ln(1.5);
    $pdf->SetFont(FONT_STYLE, LYRIC_STYLE, FONT_SIZE);
  } 
  private function writeSource($source)
  {
    if(strlen($source)<2) return;
    $pdf = $this->pdf;
    $pdf->SetFont(FONT_STYLE, COMMENT_STYLE, FONT_SIZE);
    $pdf->Write(0, $source);
    $pdf->ln();
    $pdf->SetFont(FONT_STYLE, LYRIC_STYLE, FONT_SIZE); 
  } 
  
  /*
    $pdf->getColumn() returns 0 or 1 (depending on column)
    $pdf->getNumberOfColumns() returns 0 if there is only 1 column or 2 if there are two columns
    Hence there is the need of the -1
    If the current column (0 or 1) is greater or equal to the number of columns (0 or 2) then add a page and
    select the new column. Otherwise (if current column is 0, and number of columns is 2 (-1) ), go to next column
  */
  private function columnbreak(){
    $pdf = $this->pdf;

    if($pdf->getColumn() >= $pdf->getNumberOfColumns()-1)
    {
      $pdf->AddPage('P', 'A5');
      $pdf->selectColumn(0);
    }
    else
    {
      $pdf->selectColumn($pdf->getColumn() + 1);
    }
    
    
  }
  
  public function create($songlist, $songids, $params)
  {
  
  // create new PDF document
  $this->pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  $pdf = $this->pdf;
  // set document information
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor('Jermin Tiu');
  $pdf->SetTitle('SongBook');
  $pdf->SetSubject('Song Book');
  $pdf->SetKeywords('songs');

  // remove default header/footer
  $pdf->setPrintHeader(false);
  $pdf->setPrintFooter(false);

  // set default monospaced font
  $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

  $MARGIN = 10;
  // set margins
  $pdf->SetMargins($MARGIN , $MARGIN , $MARGIN, $MARGIN );

  // set auto page breaks
  $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);

  // set image scale factor
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

  // set some language-dependent strings (optional)
  if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
      require_once(dirname(__FILE__).'/lang/eng.php');
      $pdf->setLanguageArray($l);
  }

  // ---------------------------------------------------------
  define( "FONT_SIZE" ,     !empty($params->FONT_SIZE) ? $params->FONT_SIZE : 8);
  define ("FONT_STYLE" ,    !empty($params->FONT_STYLE) ? $params->FONT_STYLE : 'times');
  define ("CHORD_SIZE" ,    !empty($params->CHORD_SIZE) ? $params->CHORD_SIZE : 8);
  define ("SONGNUM_SIZE" ,  !empty($params->SONGNUM_SIZE) ? $params->SONGNUM_SIZE : 14);
  define ("SONGNUM_STYLE", 'B');
  define ("LYRIC_STYLE", '');
  define ("CHORD_STYLE", '');
  define ("INDEX_STYLE", 'B');
  define ("COMMENT_STYLE", 'I');
  // set font
  //LYRIC FONT
  $pdf->SetFont(FONT_STYLE, LYRIC_STYLE, FONT_SIZE);

  //Set format spacing
  //Sample CHORD height
  $pdf->SetFont(FONT_STYLE, CHORD_STYLE, CHORD_SIZE);
  $chord_height =  $pdf->getStringHeight(0, "Sample string");
  
  //Sample LYRIC height
  $pdf->SetFont(FONT_STYLE, LYRIC_STYLE, FONT_SIZE);
  $line_height = $pdf->getStringHeight(0, "Sample string");
  $verse_index_tab = $pdf->getStringWidth("00. ");
  $chorus_tab = $pdf->getStringWidth("AA");
  
  // add a page
  $pdf->AddPage('P', 'A5');
  $pdf->resetColumns();

  $num_cols = 1;
  if($params->DOUBLE_COL == true)
    $num_cols = 2;
  //Set number of columns here
  $pdf->setEqualColumns($num_cols, 120/$num_cols);
  $pdf->selectColumn();
  
  $songNum = 1;
  
  $songIndex = [];
  
  // #### For each Song ####
  foreach($songids as $songid_item) 
  {
    
    //Do something about pagebreak
    if($songid_item == "pb")
    {
      $pdf->AddPage('P', 'A5');
      $pdf->selectColumn(0);
      continue;
      
    }
    if($songid_item == "cb")
    {
      $this->columnbreak();
      continue;
    }
    if($songid_item == "lb")
    {
      $pdf->Write(0, "\n");
      continue;
    }
    $song = $songlist[$songid_item];
    
    //Attempt to be smart, if I think the end of the page is near, start a new page
    //Count the number of lines in the first verse. Multiply by two for chords
    $linecount = count($song->lyrics->verses[0]->lines) < 7 ? 7 : count($song->lyrics->verses[0]->lines);
    if(($pdf->GetY() + 2*$linecount*$line_height) > ($pdf->getPageHeight() - $pdf->getBreakMargin()))
    {
      $this->columnbreak();
      
    }
    
    $songIndex[$songNum] = $song->meta_data->title;
    $song->setNum($songNum);
    $this->writeSongNum($songNum++);
    
    //
    if($params->SOURCE = true)
      $this->writeSource($song->meta_data->source);
    
    // ### For Each VERSE ####  
    foreach($song->lyrics->verses as $verse)
    {
      //Attempt to be smart - if I think the end of the page is near, start a new page
      if(($pdf->GetY() + count($verse->lines)*$line_height) > ($pdf->getPageHeight() - $pdf->getBreakMargin()))
      {
        $this->columnbreak();
      }
      //Write the verse number
      if($verse->directive->type=="verse")
      {
        $currentX = $pdf->GetX();
        $currentY = $pdf->GetY();

        if($verse->lines[0]->hasChords == true)
        {
          $pdf->setY( $pdf->getY() + $chord_height);
        }
        $pdf->SetX($currentX - $verse_index_tab);
     
        $this->writeIndex($verse->directive->param);
        $pdf->SetXY($currentX , $currentY);
        
      }
      
      //Set a flag if its the chorus (so we can indent)
      $isChorus = false;
      if($verse->directive->type=="chorus") {
        //$pdf->Write(0, "(Chorus)\n");
        $isChorus = true;
        
      }
         
      foreach($verse->lines as $line) 
      {
        //If there are chords in this verse/line, move down to make room for it
        if(isset($line->hasChords) && $line->hasChords== true)
          $pdf->setY($pdf->getY() + $chord_height);
        
        //If its a chorus, tab it
        if($isChorus == true){
          $pdf->setX($pdf->getX() + $chorus_tab);
        }
         
        //Write any comments
        if(isset($line->comment)) {
          $this->writeComment($line->comment);
        }
        else
        {
          foreach($line->chordLyricPair as $item)
          {
            //Manually check for page break (because of the way chords are displayed, it will screw up
            if($pdf->GetY() > ($pdf->getPageHeight() - $pdf->getBreakMargin()))
            {
              $this->columnbreak();
              //If its a chorus, tab it (rechec after column break);
              if($isChorus == true){
                $pdf->setX($pdf->getX() + $chorus_tab);
              }            

            }
            //If it was a column/page break, make some spapce for the chords
            if( $line->hasChords && ($pdf->GetY() - $chord_height) < $MARGIN)
            {
              $pdf->SetXY( $pdf->GetX(), $MARGIN + $chord_height);

            } 

            $currentX = $pdf->GetX();
            $currentY = $pdf->GetY();
            $pdf->Write(0, $item->lyric);
            
            $newX = $pdf->GetX();
            $newY = $pdf->GetY();
            
            $pdf->SetXY($currentX , $currentY - $chord_height);
            $this->writeChord($item->chord);
            $pdf->SetXY($newX , $newY);
            
            //Write the Chord first
              //Save the position so we can come back to it
            /*$currentX = $pdf->GetX();
            $currentY = $pdf->GetY();
              //We write the chord over the word first
            $pdf->SetXY($currentX , $currentY - $chord_height);
            $this->writeChord($item->chord);
            
              //Then come back to the lyric to write it
            $pdf->SetXY($currentX , $pdf->getY() + $chord_height);
            $pdf->Write(0, $item->lyric);*/
          }
        }
      
      //Write new line end of each line
      //$pdf->ln();
      $pdf->ln();

    }
    
    //Write new line end of each verse
    $pdf->ln();
    }
  }
  
  if($params->INDEX == true)
  {
    
    //Add index page
    $pdf->AddPage('P', 'A5');

    //set auto page break (true/false, PDF_BOTTOM_MARGIN)
    $pdf->SetAutoPageBreak(TRUE, FONT_SIZE*2);

    //Select the first column
    $pdf->selectColumn(0);
    
    //Write the heading "Index"
    $this->writeSongNum("Index");

    //set top margin
    $pdf->SetTopMargin(SONGNUM_SIZE*1.5);

    asort($songIndex);

    //For each item in the index
    // - Create a nonbreaking table with one row for each item
    foreach ($songIndex as $songI => $songIndexItem )
    {

      $html = "<table><tr nobr='true'>".
        '<td colspan="5">'.$songIndexItem."</td>".
        '<td style="text-align:center">'.$songI++."</td>".
          "</tr></table>";

      $pdf->WriteHTML($html,false);
    }

  }

  // ---------------------------------------------------------

  //Close and output PDF document
  ob_end_clean();

  //$pdf->Output('example.pdf', 'I');
  return $pdf->getPDFData();
  exit();

  //============================================================+
  // END OF FILE
  //============================================================+
  }
 
}
