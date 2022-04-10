<?php
// fetch the posts
// we will be using an API instead of a database

// get the contents from the API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://server.caila.academy/demo-api/posts');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);
curl_close($ch);

// parse the JSON output from the API
$result = json_decode($result, true);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require('./includes/header.php');?>
  </head>
  <body>
    <?php require('./includes/navbar.php') ?>
    <div class="container-fluid mt-2" id="timeline">
      <?php foreach ($result as $post): ?>
      <div class="border-start border-secondary p-4 position-relative">
        <div class="indicator">
          <button class="btn btn-rounded btn-secondary py-0 px-2">&nbsp;</button>
        </div>
        <div class="card">
          <div class="card-header"> <?php echo $post['dateCreated']; ?> </div>
          <div class="card-body">
            <blockquote class="blockquote mb-0">
              <p> <?php echo $post['message']; ?> </p>
              <footer class="blockquote-footer"> <?php echo $post['nickname']; ?> </footer>
            </blockquote>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.js"></script>
  </body>
</html>
