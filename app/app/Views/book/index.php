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
</style>

<div class="text-center main-container">

  
  
  <input type="text" id="mySearch" onkeyup="myFunction()" placeholder="Search.." title="Type in a category">

    <ul id="myMenu">

  <?php if (!empty($books) && is_array($books)): ?>
  
    <div class="list-group" id="list-tab" role="tablist">
    
    <?php foreach ($books as $book_item): ?>

      <li><a href="<?='/book/'.$book_item['id'] ?>"><?= $book_item['name'] ?></a></li>
      <!--<a href="<?='/book/'.$book_item['id'] ?>" class="list-group-item"><?= $book_item['name'] ?></a>
      <button type="button" class="list-group-item list-group-item-action" data-toggle="list" role="tab">
        
      <!--</button>-->
    
    <?php endforeach; ?>
    </div>
    </ul>
  <?php else : ?>
    <h3>No Books</h3>
    
    <p>Unable to find any books or connect to the database</p>
  <?php endif ?>

  <form action="create">

    <h3>Create new Book</h3>
    <label for="name">Book Name: </label>
    <input type="text" id="name" name="name" placeholder="Enter book Name" title="Enter book name" />

    <input type="submit" name="submit" value="Create" />
  </form>

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