<?php
// fetch the posts
// we will be using an API instead of a database

// get the contents from the API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://server.caila.academy/demo-api/posts');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);
curl_close($ch);

// parse the JSON string
$result = json_decode($result, true);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Tiny MCE -->
    <script src="https://cdn.tiny.cloud/1/tfm5foww7vz4goyjlhvxlgd7rdn0jo0emir5zx3881dr1d81/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <!-- Font Awesome -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      rel="stylesheet"
    />
    <!-- Google Fonts -->
    <link
      href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap"
      rel="stylesheet"
    />
    <!-- MDB -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./style.css" />
    <title>CAILA | Freedom Wall</title>
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top bg-light navbar-light">
      <button
        class="navbar-toggler"
        type="button"
        data-mdb-toggle="collapse"
        data-mdb-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="true"
        aria-label="Toggle navigation"
      >
        <i class="fas fa-bars"></i>
      </button>
      <div class="container d-flex justify-content-center">
        <div class="row">
          <div class="col-12 d-flex justify-content-center">
            <a class="navbar-brand" href="#">
              <img src="./images/logo.png" class="me-2" height="30" />
              <small class="border-start border-secondary"
                >&nbsp;Freedom Wall</small
              >
            </a>
          </div>
          <div class="col-12 d-flex justify-content-center">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav align-items-center mx-auto">
                <li class="nav-item">
                  <a class="nav-link mx-2" href="./post.php"
                    ><i class="fas fa-plus-circle pe-2"></i>Post</a
                  >
                </li>
                <li class="nav-item">
                  <a class="nav-link mx-2" href="./about.php"
                    ><i class="fas fa-circle-info pe-2"></i>About</a
                  >
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <!-- Navbar -->
    <div class="container-fluid mt-2" id="timeline">
      <?php foreach ($result as $post): ?>
      <div class="border-start border-secondary p-4 position-relative">
        <div class="indicator">
          <button class="btn btn-rounded btn-secondary py-0 px-2">&nbsp;</button>
        </div>
        <div class="card">
          <div class="card-header">
            <?php echo $post['dateCreated']; ?>
          </div>
          <div class="card-body">
            <blockquote class="blockquote mb-0">
              <p>
                <?php echo $post['message']; ?>
              </p>
              <footer class="blockquote-footer">
                <?php echo $post['nickname']; ?>
              </footer>
            </blockquote>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
    <script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.js"
    ></script>
<script>
tinymce.init({
  selector: 'textarea',
  plugins: 'autolink link',
  toolbar: 'undo redo | styleselect | bold italic link | alignleft aligncenter alignright alignjustify | outdent indent',
  menubar: '',
  toolbar_mode: 'floating',
  tinycomments_mode: 'embedded',
  tinycomments_author: 'Author name',
  link_assume_external_targets: true,
  link_default_protocol: 'http',
});

</script>
  </body>
</html>
