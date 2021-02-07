<style>
/* Style the search box */
#mySearch {
  width: 100%;
  font-size: 18px;
  padding: 11px;
  border: 1px solid #ddd;
}

/* Style the navigation menu */
#myMenu {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

/* Style the navigation links */
#myMenu li a {
  padding: 12px;
  text-decoration: none;
  color: black;
  display: block
}

#myMenu li a:hover {
  background-color: #eee;
}

.main-container {
  max-width: 800px;
  margin: auto;
}

#list-tab {
  height: 60vh;
}

html, body { height: 100%;}
</style>

<div class="main-container">

<div class="container">

  <div class="menu text-center">
    <h3><a href="load">Load Song</a></h3>
    <h3><a href="books">Books</a></h3>
  </div>
  
  <input type="text" id="mySearch" onkeyup="myFunction()" placeholder="Search.." title="Type in a category">

    

  <?php if (!empty($songs) && is_array($songs)): ?>
  
    <div class="list-group overflow-auto" id="list-tab" role="tablist">
    <ul id="myMenu">
    <?php foreach ($songs as $song_item): ?>

      <li><a href="<?='/song/'.$song_item['id'] ?>"><?= $song_item['title'] ?></a></li>
      <!--<a href="<?='/song/'.$song_item['id'] ?>" class="list-group-item"><?= $song_item['title'] ?></a>
      <button type="button" class="list-group-item list-group-item-action" data-toggle="list" role="tab">
        
      <!--</button>-->
    
    <?php endforeach; ?>
    </ul>
    </div>
    
  <?php else : ?>
    <h3>No Songs</h3>
    
    <p>Unable to find any songs or connect to the database</p>
  <?php endif ?>
</div>
</div>

<script>
function myFunction() {
  // Declare variables
  var input, filter, ul, li, a, i;
  input = document.getElementById("mySearch");
  filter = input.value.toUpperCase();
  ul = document.getElementById("myMenu");
  li = ul.getElementsByTagName("li");

  // Loop through all list items, and hide those who don't match the search query
  for (i = 0; i < li.length; i++) {
    a = li[i].getElementsByTagName("a")[0];
    if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
      li[i].style.display = "";
    } else {
      li[i].style.display = "none";
    }
  }
}
</script>