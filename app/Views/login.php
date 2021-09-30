<!doctype html>
<html>

<head>
	<title>Login - Ponteon Soluções Digitais</title>

	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

	<style type="text/css">
		body {
			font-family: "Lato", sans-serif;
		}

		.main-head {
			height: 150px;
			background: #FFF;
		}

		.sidenav {
			height: 100%;
			background: linear-gradient(to bottom, #555555 0%,#313131 100%);
			overflow-x: hidden;
			padding-top: 20px;
		}

		.main {
			padding: 0px 10px;
		}

		@media screen and (max-height: 450px) {
			.sidenav {
				padding-top: 15px;
			}
		}

		@media screen and (max-width: 450px) {
			.login-form {
				margin-top: 10%;
			}

			.register-form {
				margin-top: 10%;
			}
		}

		@media screen and (min-width: 768px) {
			.main {
				margin-left: 40%;
			}

			.sidenav {
				width: 40%;
				position: fixed;
				z-index: 1;
				top: 0;
				left: 0;
			}

			.login-form {
				margin-top: 80%;
			}

			.register-form {
				margin-top: 20%;
			}
		}


		.login-main-text {
			margin-top: 20%;
			padding: 60px;
			color: #fff;
		}

		.login-main-text h2 {
			font-weight: 300;
		}

		.btn-black {
			background-color: #000 !important;
			color: #fff;
		}
	</style>
</head>

<body>
	<div class="sidenav">
		<div class="login-main-text">
			<h2>Sistema<br> Gerenciamento de Enquetes</h2>
			<p>Teste para vaga de DEV Junior da Ponteon - Soluções Digitais Integradas.</p>
		</div>
	</div>
	<div class="main">
		<?php
		// Display Response
		if (session()->has('message')) {
		?>
			<div class="alert <?= session()->getFlashdata('alert-class') ?>">
				<?= session()->getFlashdata('message') ?>
			</div>
		<?php
		}
		?>
		<div class="col-md-6 col-sm-12">
			<div class="login-form">
				<form action="<?= site_url('users/login') ?>" method="post">
					<div class="form-group">
						<label>Email</label>
						<input type="text" name="email" class="form-control" placeholder="email@email.com">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" name="password" class="form-control" placeholder="123">
					</div>
					<button type="submit" class="btn btn-black">Entrar</button>
				</form>
			</div>
		</div>
	</div>
</body>

</html>

<?= $this->section('content') ?>
<!-- <div class="container h-80">
	<div class="row align-items-center h-100">
		<div class="col-5 mx-auto">
			<div class="text-center">
				<p id="profile-name" class="profile-name-card"></p>
				<form class="form-signin">

					<input type="text" name="email" id="inputEmail" class="form-control form-group" placeholder="email@email.com" required autofocus>
					<input type="password" name="password" id="inputPassword" class="form-control form-group" placeholder="123" required>
					<button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Entrar</button>
				</form>
			</div>
		</div>
	</div>
</div> -->


<?= $this->endSection() ?>