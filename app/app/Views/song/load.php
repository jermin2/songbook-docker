<style>

.loadbtn {
  margin: 10px 10px;
  padding-left: 30px;
  padding-right: 30px;
}

.buttonhelp {
  margin: 20px;
  
  
  
}
</style>


<div class="main-container">

  <div class="container">
  <?= $validation->listErrors() ?>
    <form action="load" method="post">
      <input type="hidden" name="id" value='<?= $id ?>'/><br />
      <button type="button" class="btn btn-info buttonhelp" onClick="showhelp()">Click here for help</button>
  
      <h1 class="helptext"> Enter a URL here... </h1>
      <div class="form-group" id="loadurlgroup" >
        <small id="urlhelp" class="form-text text-muted">Enter the <a href="http://songbase.life">songbase.life</a> or <a href="http://hymnal.net">hymnal.net</a> url </small>
        <input type="input" class="form-control" id="targeturl" name="url" />
        <button class="btn btn-primary loadbtn" onClick="loadHTML()" >Get Song </button> <h2 class="helptext"> &emsp;^ ....Then push this button.... </h2><br />
        <h2 class="helptext" style="color:grey">&emsp;&emsp;&emsp;.....Remember to click the green button at the bottom </h2>
      </div>
  
      <h1 class="helptext"> Or just start typing a song </h1>
  
      <div class="form-group" id="editsongfields">
        <small class="form-text">Title*</small>
        <input type="input" class="form-control" id="title" name="title" placeholder="Title (required)" value='<?= $title ?>'/><br />
      
        <div class="form-row">
          <div class="form-group col-md-6">
            <small class="form-text">Source</small>
            <input type="input" class="form-control" name="source" placeholder="Source (example BSB #274)" value='<?= $source ?>'/><br />
          </div>
          <div class="form-group col-md-6">
          <small class="form-text">Author</small>
            <input type="input" class="form-control" name="author" placeholder="Author" value='<?= $author ?>'/><br />
          </div>
        </div>
  
        <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Open Lyric Help</button> <br />

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Lyric Syntax</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <p><b>Verse</b> numbers are indicated by {verse: x} where x is the number at the start of the verse </p>
                <p>For example: <br/> <i>{verse: 1}</br>Pursue Him! And know Him! Be found...</i></p>
                <p><b>Chorus'</b> are indicated by using the {chorus} tag at the start of the chorus</p>
                <p>For example: <br /> <i>{chorus}<br />Forgetting the things, which are behind...</i></p>
                <p><b>Chords</b> are indicated by wrapping the chord in '[ ]' square brackets, before the place the chord appears<p>
                <p>For example: <br /> <i>[G]Pursue Him [B7]and know Him; </i> <p>
                <p><b>Comments</b> can be placed by using the {comment: x} tag in a new line</p>
                <p>For example: <br /><i>Count all things loss for Him! <br />{comment: clap clap clap clap clap}<br />Forgetting and leaving...</i><p>
                <p>Comments can appear anywhere in the song including the start <i>{comment: Capo 2}</i></p>
                <p>Basic HTML tags are also supported in comments, such as &lt;b>&lt;i>&lt;br /></p>
                <p>For example: <br /><i>{comment: &lt;b> this is a bold comment &lt;/b>} </i> <br />will appear as <br /><b>this is a bold comment</b></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>
          <!-- Trigger the modal with a button -->
  
        <label for="lyricfield" >Lyrics*</label><br />    

        <textarea name="lyricfield" class="form-control" id="lyricfield" rows="20" cols="70" placeholder="Lyrics (required)"/><?= $lyrics ?></textarea><br />

        <input type="submit" class="btn btn-success" id="submitbutton" name="submit" value="Save to SongBook" />
      </div>
    </form>
  </div>
</div>

<script>
$( document ).ready( function(){
  //Hide HTML elements depending if this is a load or edit
  var type = "<?= $type ?>";
  console.log("hi");
  if (type == "edit")
  {
    document.getElementById("loadurlgroup").style.display = 'none';
    document.getElementById("submitbutton").value="Save Changes";
    $('.buttonhelp').hide();
  }
  if (type=="load")
  {
    //document.getElementById("editsongfields").style.display = 'none';
  }
  
  $('.helptext').hide();
 
  
});


  function showhelp(){

    elements = document.getElementsByClassName("helptext");
    for (var i = 0; i < elements.length; i++) {
        elements[i].style.display = elements[i].style.display == 'inline' ? 'none' : 'inline';
    } 
  }

  function loadHTML(){
    event.preventDefault();
    
    var targeturl = document.getElementById("targeturl");
    var url = "/song/loadurl";
    var data = {targeturl : targeturl.value};
    
    $.ajax({
      type: "POST",
      url : url,
      data: JSON.stringify(data),
      contentType:  "application/json; charset=utf-8",
      dataType: "json",
      error: function(xhr, status, error) {
        alert(xhr.responseText);
      },
      success: function(response) {
        var lyricfield = document.getElementById("lyricfield");
        lyricfield.innerHTML = response['html'];
        
        document.getElementById("title").value=response['title'];
        document.getElementById("editsongfields").style.display = 'block';
      }
    });
      
    
    
  }



</script>