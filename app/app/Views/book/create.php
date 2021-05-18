<style>

.selectable-song.disabled {
  background-color: #cccccc;
}

  #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
  #sortable li span { position: absolute; margin-left: -1.3em; }
  
.songlist {
  height: 60vh;
  padding: 0px;
}

.list-group-item {
  
  font-size: 0.9rem;
  padding: .3rem;
}


  div.line {
    display: block;
  }

  span.line-text {
    vertical-align: bottom;
    font-size: 10.4pt;
  }

  span.chord {
    position: relative;
    padding-top: 17px;
    top: -17px;
    display:inline-block;
    width: 0;
    overflow:visible;
    font-weight:bold;
    font-size: 8pt;
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
    font-size: 10.4pt;
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
  
  .songnum {
    font-size: 18.2pt;
  }


<script src="js/jquery.fs.stepper.min.js"></script>
<link href="css/jquery.fs.stepper.css" rel="stylesheet" type="text/css">


  
</style>
<div class="id"><?php echo $id; ?></div>

<div class="container">
  <button type="button" class="btn btn-info buttonhelp" onClick="showhelp()">Click here for help</button>
  <div class="row">
    <div class="col-6">
      <div class="form-group">
        
        <h4>Select Songs</h4> <h2 class="helptext"> 1.Select a song/s from this list...</h2>
      
        <input type="text" class="form-control" id="mySearch" onkeyup="filterSongList()" placeholder="Search.." title="Type in a category">
        
        <?php if(!empty($songs) && is_array($songs)): ?>
          
          <ul id="songlist" class="list-group songlist overflow-auto" role="tablist">
            <?php foreach ($songs as $song_item): ?>
              <li><span onClick="toggleSelect(this)" class="list-group-item list-group-item-action selectable-song" id="<?=$song_item['id'] ?>" songid="<?=$song_item['id'] ?>" title="<?=$song_item['title'] ?>"><?=$song_item['title'] ?></span>  </li>
            <?php endforeach; ?>
          </ul>
        <?php else : ?>
          <h3>No songs </h3>
        <?php endif ?>
          
      </div>
  
    </div>
    <div class="col-1 my-auto">
      <div class="btn-group btn-group-sm btn-group-vertical my-auto">
      <h2 class="helptext">2. Click the add button</h2>
        <button class="btn btn-primary" id="add" >Add</button>
        <button class="btn btn-danger" id="remove" type="button">Remove</button>
                <button class="btn btn-warning" id="pb" type="button">Add Page Break</button>
        <button class="btn btn-dark" id="cb" type="button">Add Col Break</button>
      </div>
      
    </div>
    <div class="col-5">



      <h3>Chosen Songs</h3>
      <div id="chosenlist" class="list-group songlist overflow-auto" role="tablist"></div>
      
      <div class="btn-group btn-group-sm float-right">
      <h2 class="helptext">3. Click the generate button to make your song book</h2>
      <button class="btn btn-primary float-right" onClick="saveBook()" id="save" type="button">Save Song Book</button>
      <button class="btn btn-success float-right" onClick="generatePDF()" id="pdf" type="button">Generate PDF</button>
      </div>
      <br />
      <br />

      
    </div>
  </div>
  <h2 class="helptext">4. Additional optional settings below here</h2>
  <div class="row">
    <div class="form-group col-6">
      <h2>Additional Settings</h2>
      <div class="form-group row">
        <label for="fontsize" class="col-8">Font Size</label>
        <input type="number" id="fontsize" class="form-control col-3" name="fontsize" value="8" min="4" max="20" step="0.5"/>
      </div>
      <div class="form-group row">
        <label for="chordsize" class="col-8">Chord font size</label>
        <input type="number" id="chordsize" class="form-control col-3" name="chordsize" value="8" min="4" max="20" step="0.5"/>
      </div>
      <div class="form-group row">
        <label for="songnumsize" class="col-8">Song number size</label>
        <input type="number" id="songnumsize" class="form-control col-3" name="songnumsize" value="14" min="4" max="20" step="0.5"/>
      </div>
      <div class="form-group row">
        <label for="songnumsize" class="col-6">Font style</label>
        <select class="custom-select col-5" id="selectfont">
          <option value="times" style="font-family:times" selected>times</option>
          <option value="courier" style="font-family:courier" >courier</option>
          <option value="helvetica" style="font-family:helvetica">helvetica</option>
        </select>
      </div>
      <div class="form-group row">
        <label for="dblColumn" class="col-10">Double Column</label>
        <input type="checkbox" class="col-2" id="dblColumn" name="dblColumn" checked/>
      </div>
      <div class="form-group row">
        <label for="showindex" class="col-10">Include index page at the end</label>
        <input type="checkbox" class="col-2" id="showindex" name="showindex" checked/>
      </div>
      <div class="form-group row">
        <label for="showsource" class="col-10">Include source in the song</label>
        <input type="checkbox" class="col-2" id="showsource" name="showsource" checked/>
      </div>
      <input type="hidden" name="chosenlist[]" id="chosenlist" />
    </div>
    
  
  
    <div class="col-6">
      <h2>Preview</h2>
      <div class="songnum" >1</div>
      <div class="verse"></div>
      <div class="verse"><div class="verse-number"> 1</div>	
      <div class="line"> <span class="line-text"><span class="chord" uncopyable-text="">G</span>A flowing river <span class="chord" uncopyable-text="">C</span>and a <span class="chord" uncopyable-text="">G</span>tree,</span></div>	
      <div class="line"> <span class="line-text"><span class="chord" uncopyable-text=""></span>Eden’s out<span class="chord" uncopyable-text="">C</span>standing features <span class="chord" uncopyable-text="">G</span>are,
      </span></div>	
      <div class="line"> <span class="line-text"><span class="chord" uncopyable-text=""></span>Man to sup<span class="chord" uncopyable-text="">D</span>ply with food and drink</span></div>	
      <div class="line"> <span class="line-text"><span class="chord" uncopyable-text=""></span>That he may <span class="chord" uncopyable-text="">A</span>live for<span class="chord" uncopyable-text="">D</span>e’er.</span></div></div>
      <div class="verse">
      <div class="chorus">	
      <div class="line"> <span class="line-text"><span class="chord" uncopyable-text=""></span>God is in <span class="chord" uncopyable-text="">G</span>Christ to be my sup<span class="chord" uncopyable-text="">D</span>ply,</span></div>	
      <div class="line"> <span class="line-text"><span class="chord" uncopyable-text=""></span>God as the Spirit nourisheth <span class="chord" uncopyable-text="">G</span>me;</span></div>	
      <div class="line"> <span class="line-text"><span class="chord" uncopyable-text=""></span>If upon Christ in spirit I <span class="chord" uncopyable-text="">C</span>feed,</span></div>	
      <div class="line"> <span class="line-text"><span class="chord" uncopyable-text=""></span>Filled with His <span class="chord" uncopyable-text="">D</span>life I’ll <span class="chord" uncopyable-text="">G</span>be.</span></div></div></div>
    </div>
  
  </div>
  
</div>

<script>
  function toggleSelect(button){
    $(button).toggleClass("active");
  }
  
  function filterSongList() {
    // Declare variables
    var input, filter, ul, li, a, i;
    input = document.getElementById("mySearch");
    filter = input.value.toUpperCase();
    ul = document.getElementById("songlist");
    li = ul.getElementsByTagName("li");

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
      span = li[i].getElementsByTagName("span")[0];
      if (span.innerHTML.toUpperCase().indexOf(filter) > -1) {
        li[i].style.display = "";
      } else {
        li[i].style.display = "none";
      }
    }
  }
  

  
  //Create a list of the songids to create the PDF
  function generatePDF(){
    //Get the chosen list
    var list = document.getElementById("chosenlist");
    
    // Get the items in the chosen list
    var items = document.getElementsByClassName("list-group-item chosen-items")
    
    //create a blank array to store the song ids
    var songids = [];
    
    for(i=0; i<items.length; i++)
    {
      songids[i] = items[i].getAttribute("songid");
    }
    
    var fontsize = document.getElementById("fontsize").value;
    var songnumsize = document.getElementById("songnumsize");
    var chordsize = document.getElementById("chordsize");
    var e = document.getElementById("selectfont");
    var fontstyle = e.options[e.selectedIndex].value;
    var index = document.getElementById("showindex").checked;
    var dblCol = document.getElementById("dblColumn").checked;
    var showsource = document.getElementById("showsource").checked;
    
    var params = { 
        "FONT_STYLE" : fontstyle,
        "FONT_SIZE" : fontsize,
        "CHORD_SIZE" : chordsize.value,
        "SONGNUM_SIZE" : songnumsize.value,
        "DOUBLE_COL" : dblCol,
        "INDEX"       : index,
        "SOURCE"      : showsource,
    };

    console.log(songids);

    var data = {
      "params"    : params,
      "values"    : songids
    };    
    
    var url = "/book/createPDF";

    $.ajax({
      type:         "POST",
      url:          url,
      data:         JSON.stringify(data),
      contentType:  "application/json; charset=utf-8",
      dataType:     "json",
      error: function(xhr, status, error) {
        alert(xhr.responseText);
      },
      success: function(response) {
        
      }
    })
    .done(function(response) {    
        var a = document.createElement('a');
        a.href= "data:application/octet-stream;base64,"+response['pdf'];
        a.target = '_blank';
        a.download = 'filename.pdf';
        a.click();
    });
    
  }
  
   $( function() {
  $( "#chosenlist" ).sortable();
} ); 


function loadBook(){
  var id = '<?php echo $id; ?>';
  var songids = '<?php echo implode(",",$songids); ?>';
  var name = '<?php echo $name; ?>';
  var ss = '<?php echo $params; ?>';
  var l = '<?php echo json_encode($songids); ?>';
  console.log(l);
  console.log(songids);

  loadBookAJAX(id);
}



function loadBookAJAX(id){

  var url = "/book/loadBook";
  var data = {
      "id" : id
    }

  $.ajax({
      type:         "POST",
      url:          url,
      data:         JSON.stringify(data),
      contentType:  "application/json; charset=utf-8",
      dataType:     "json",
      error: function(xhr, status, error) {
        alert(xhr.responseText);
      },
      success: function(response) {
        console.log(response);
        //Change the parameters


        //Add the chosen songs to the list
        //for each 
        console.log(songlist);
        for(i=0; i<response['songids'].length; i++)
        {
          //Grab the next id
          var id = response['songids'][i];

          console.log(id);

          //Grab the element corresponding to the id
          var e = document.getElementById(id);

          //Make this item active
          e.classList.add("active")

          //simulate an add action
          $("#add").trigger("click");

          if (id=="pb")
          {
            $("#pb").trigger("click");
          } else if (id=="cb")
          {
            $("#cb").trigger("click");
          }

          
        }

      }
    })

}
function saveBook(){
  //Get the chosen list
    var list = document.getElementById("chosenlist");
    
    // Get the items in the chosen list
    var items = document.getElementsByClassName("list-group-item chosen-items")
    
    //create a blank array to store the song ids
    var songids = [];
    
    for(i=0; i<items.length; i++)
    {
      songids[i] = items[i].getAttribute("songid");
    }
    
    var fontsize = document.getElementById("fontsize").value;
    var songnumsize = document.getElementById("songnumsize");
    var chordsize = document.getElementById("chordsize");
    var e = document.getElementById("selectfont");
    var fontstyle = e.options[e.selectedIndex].value;
    var index = document.getElementById("showindex").checked;
    var dblCol = document.getElementById("dblColumn").checked;
    
    var params = { 
        "FONT_STYLE" : fontstyle,
        "FONT_SIZE" : fontsize,
        "CHORD_SIZE" : chordsize.value,
        "SONGNUM_SIZE" : songnumsize.value,
        "DOUBLE_COL" : dblCol,
        "INDEX"       : index,
        "SOURCE"      :showsource,
    };



    var id = '<?php echo $id; ?>';
    var name = '<?php echo $name; ?>';

    console.log(songids);
    console.log(params);
    console.log(id);
    console.log(name);

    var data = {
      "params"    : params,
      "values"    : songids,
      "id"        : id,
      "name"      : name
    };    
    
    var url = "/book/saveBook";

    $.ajax({
      type:         "POST",
      url:          url,
      data:         JSON.stringify(data),
      contentType:  "application/json; charset=utf-8",
      dataType:     "json",
      error: function(xhr, status, error) {
        alert(xhr.responseText);
      },
      success: function(response) {
        console.log(response);
      }
    })

    console.log("reached the end somehow");

}

  $('#selectfont').change(function(){
    var e = document.getElementById("selectfont");
    var fontstyle = e.options[e.selectedIndex].value;
    $('.line-text').css("font-family", fontstyle);
  })  
  
  function showhelp(){

    elements = document.getElementsByClassName("helptext");
    for (var i = 0; i < elements.length; i++) {
        elements[i].style.display = elements[i].style.display == 'inline' ? 'none' : 'inline';
    } 
  }
    
$(document).ready(function(){
  
  $('.helptext').hide();
  

  $(document).on('input', '#fontsize', function(){
    var fontsize = $("#fontsize").val()*1.3;
    $('.line-text').css("font-size", fontsize+"pt");
    var chordsize = $("#chordsize").val()*1.3;
    $('.chord').css("font-size", chordsize+"pt");
  })
  
  $(document).on('input', '#chordsize', function(){
    var chordsize = $("#chordsize").val()*1.3;
    $('.chord').css("font-size", chordsize+"pt");
  })
  
  $(document).on('input', '#songnumsize', function(){
    var songnumsize = $("#songnumsize").val()*1.3;
    $('.songnum').css("font-size", songnumsize+"pt");
  })

  
  $('#pb').on('click', function() {
    
    var item = document.getElementsByClassName("list-group-item chosen-items active")[0];
    
    var newPageBreak = document.createElement("span");
    var textnode = document.createTextNode("Page Break");
    newPageBreak.appendChild(textnode);
    
    newPageBreak.setAttribute("songid", "pb");
    newPageBreak.setAttribute("data-toggle", "list");
    newPageBreak.setAttribute("role", "tab");
    newPageBreak.className = "list-group-item chosen-items";
    
    var list = document.getElementById("chosenlist");
    list.insertBefore(newPageBreak, item.nextSibling);

  });
  
  $('#cb').on('click', function() {
    
    var item = document.getElementsByClassName("list-group-item chosen-items active")[0];
    
    var newPageBreak = document.createElement("span");
    var textnode = document.createTextNode("Col Break");
    newPageBreak.appendChild(textnode);
    
    newPageBreak.setAttribute("songid", "cb");
    newPageBreak.setAttribute("data-toggle", "list");
    newPageBreak.setAttribute("role", "tab");
    newPageBreak.className = "list-group-item chosen-items";
    
    var list = document.getElementById("chosenlist");
    list.insertBefore(newPageBreak, item.nextSibling);

    
    
    
  });
  
  //Remove from the "chosen" list and make it available in the songlist
  $('#remove').on('click', function() {
    event.preventDefault();
    
    //Get the item
    var item = document.getElementsByClassName("list-group-item chosen-items active")[0];
    
    //Make it selectable again
    var item_id = item.getAttribute("id");
    $('#'+item_id).removeClass("disabled");
    $('#'+item_id).removeClass("list-group-item-secondary");
    
    //remove it from the chosen songs list
    item.parentNode.removeChild(item);
    
  });
  
  //Hand action when the "add" button is clicked to add songs from the songlist to the chosen list (under the selected song)
  $('#add').on('click', function() {
    event.preventDefault();
    
    //For each selectable-song, that is ACTIVE
    $(".selectable-song").each(  function() {
      if ($(this).hasClass("active") ){
        
        //Get the ID and TITLE
        var id = $(this).attr('id');
        var title = $(this).attr('title');
        
        $(this).removeClass("active");
        $(this).addClass("list-group-item-secondary");
        $(this).addClass("disabled");
              
        //Add it to the chosenlist
        //Get the selected item
        var item = document.getElementsByClassName("list-group-item chosen-items active")[0];
    
        var newItem = document.createElement("span");
        var textnode = document.createTextNode(title);
        newItem.appendChild(textnode);
        
        newItem.setAttribute("songid", id);
        newItem.setAttribute("id", id);
        newItem.setAttribute("data-toggle", "list");
        newItem.setAttribute("role", "tab");
        newItem.className = "list-group-item chosen-items list-group-item-action active"; //make it the selected song
        
        var list = document.getElementById("chosenlist");
        
        //list.insertBefore(newItem, item);
        list.appendChild(newItem);
        $(item).removeClass("active");
        
      }
    });
    
    
  });
  
});

loadBook();
</script>
