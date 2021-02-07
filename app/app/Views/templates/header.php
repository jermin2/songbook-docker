<!doctype html>
<html>
<head>
  <title>Song Book</title>
  
  <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  -->
  <script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
  <script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
  integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
  crossorigin="anonymous"></script>
  
  
  
  <!-- Bootstrap css and js -->
  
  
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
  rel="stylesheet" 
  integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" 
  crossorigin="anonymous">
  
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" 
  integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" 
  crossorigin="anonymous"></script>


  <style>
.main-title {
  padding: 2rem 0rem 1rem;
  text-align:center;
}

.sub-title {
  padding: 0.5rem 1rem;
  text-align:center;
}
</style>

</head>
<body>


<div id="container-fluid">
	<div class="main-title">
    <h1><a href="<?php echo base_url(); ?>">SongBook</a></h1>
  </div>
  
	<div class="sub-title">
    <h2><?= esc($heading); ?></h2>
  </div>  
  
  
    