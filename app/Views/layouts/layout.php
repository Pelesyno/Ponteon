<!doctype html>
<html>

<head>
  <title>Teste - Ponteon Soluções Digitais</title>

  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

  <style type="text/css">
    .mb20 {
      margin-bottom: 20px;
    }

    .actionbutton {
      width: 100%;
      height: 55px;
    }

    .errors {
      color: red;
    }

    body {
      font-family: "Lato", sans-serif;
    }

    .bg-navbar {
      background-color: #273396;
    }

    .bg-footer {
      background: linear-gradient(to bottom, #555555 0%, #313131 100%);
      color: rgba(255, 255, 255, 0.6);
      text-shadow: 1px 1px 1px rgb(0 0 0 / 10%);
      font-size: 13px;
    }
  </style>
</head>

<body>
  <?php
  $session = \Config\Services::session();
  if ($session->get('logged')) :
  ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-navbar">
      <a class="navbar-brand" href="#">Ponteon</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="/enquetes">Enquetes </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="#">Usuarios </a>
          </li>
        </ul>
        <span class="navbar-text">
          <form class="form-inline">
            <div><?= $session->get('username'); ?></div>
            <a class="btn btn-outline-success ml-2 my-2 my-sm-0" href="/users/logout">Sair</a>
          </form>
        </span>
      </div>
    </nav>
  <?php endif; ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <?= $this->renderSection('content') ?>
      </div>
    </div>
  </div>
  <nav class="navbar fixed-bottom bg-footer">
    <div>Daniel da Silva Rodrigues</div>
    © Todos os direitos reservados
  </nav>
</body>

</html>