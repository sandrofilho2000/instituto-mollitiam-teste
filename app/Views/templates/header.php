<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Meu Site</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/styles.css'); ?>">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-custom ">
  <div class="container-fluid d-flex justify-content-between">
    <a href="https://institutomollitiam.org.br/">
        <img fetchpriority="high" width="161" height="47" src="https://institutomollitiam.org.br/wp-content/uploads/2024/11/Logo-mollitian-1.png" class="attachment-full size-full wp-image-730" alt="" srcset="https://institutomollitiam.org.br/wp-content/uploads/2024/11/Logo-mollitian-1.png 600w, https://institutomollitiam.org.br/wp-content/uploads/2024/11/Logo-mollitian-1-300x89.png 300w" sizes="(max-width: 600px) 100vw, 600px">								
    </a>    
    <button class="navbar-toggler btn-custom" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-custom" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>