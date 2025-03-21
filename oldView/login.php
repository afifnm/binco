<!DOCTYPE html>
<html lang="en" class="light">
<!-- BEGIN: Head -->

<head>
	<meta charset="utf-8">
	<link href="<?= base_url('assets/')?>logo.png" rel="shortcut icon">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="LEFT4CODE">
	<title>App Kasir</title>
	<!-- BEGIN: CSS Assets-->
	<link rel="stylesheet" href="<?= base_url('assets/')?>dist/css/app.css" />
	<!-- END: CSS Assets-->
</head>
<!-- END: Head -->

<body class="login">
	<div class="container sm:px-10">
		<div class="block xl:grid grid-cols-2 gap-4">
			<!-- BEGIN: Login Info -->
			<div class="hidden xl:flex flex-col min-h-screen">
				<a href="" class="-intro-x flex items-center pt-5">
					<img alt="Midone - HTML Admin Template" class="w-6"
						src="<?= base_url('assets/')?>logo.png">
					<span class="text-white text-lg ml-3"> App Kasir </span>
				</a>
				<div class="my-auto">
					<img alt="Midone - HTML Admin Template" class="-intro-x w-1/2 -mt-16"
						src="<?= base_url('assets/')?>dist/images/illustration.svg">
					<div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
						PT Binco Ran Nusantara
					</div>
				</div>
			</div>
			<!-- END: Login Info -->
			<!-- BEGIN: Login Form -->
			<div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
				<div
					class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
					<h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
						Login
					</h2>
					<form action="<?= base_url('auth/login') ?>" method="POST">
						<div class="intro-x mt-8">
							<input type="text" class="intro-x login__input form-control py-3 px-4 block" name="username"
								required placeholder="Username">
							<input type="password" class="intro-x login__input form-control py-3 px-4 block mt-4"
								name="password" required placeholder="Password">
						</div>
						<div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
							<?= $this->session->flashdata('notifikasi'); ?>
							<button class="button button--lg w-full xl:w-32 text-white bg-theme-1 xl:mr-3">Login</button>
						</div>
					</form>
				</div>
			</div>
			<!-- END: Login Form -->
		</div>
	</div>
	<!-- BEGIN: JS Assets-->
	<script src="<?= base_url('assets/')?>dist/js/app.js"></script>
	<!-- END: JS Assets-->
</body>

</html>