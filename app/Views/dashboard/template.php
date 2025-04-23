<html lang="es">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<title>LIBRO DE RECLAMACIONES</title>
	<!-- CSS files -->
	<link rel="stylesheet" href="<?= base_url('public/dist/css/tabler.min.css?1738096682') ?>" />
	<link rel="stylesheet" href="<?= base_url('public/dist/css/tabler-flags.min.css?1738096682') ?>" />
	<link rel="stylesheet" href="<?= base_url('public/dist/css/tabler-socials.min.css?1738096682') ?>" />
	<link rel="stylesheet" href="<?= base_url('public/dist/css/tabler-payments.min.css?1738096682') ?>" />
	<link rel="stylesheet" href="<?= base_url('public/dist/css/tabler-vendors.min.css?1738096682') ?>" />
	<link rel="stylesheet" href="<?= base_url('public/dist/css/tabler-marketing.min.css?1738096682') ?>" />
	<link rel="stylesheet" href="<?= base_url('public/dist/css/demo.min.css?1738096682') ?>" />
	<link rel="stylesheet" href="<?= base_url('public/dist/libs/fontawesome-free-6.7.2-web/css/fontawesome.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('public/dist/libs/fontawesome-free-6.7.2-web/css/solid.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('public/dist/libs/sweetalert2/dist/sweetalert2.css') ?>" />

	<?= $this->renderSection('estilos'); ?>


	<style>
		@import url('https://rsms.me/inter/inter.css');
	</style>
</head>

<body class=" layout-fluid">
	<script src="<?= base_url('public/dist/js/demo-theme.min.js') ?>" defer></script>

	<div class="page">
		<!-- Sidebar -->
		<?= $this->include('dashboard/aside') ?>
		<div class="page-wrapper">
			<!-- Page header -->
			<div class="page-header d-print-none">
				<div class="container-xl">
					<div class="row g-2 align-items-center">
						<div class="col">
							<!-- Page pre-title -->
							<div class="page-pretitle">
								By @zleonxrdo_
							</div>

							<h2 class="page-title">
								<?= $this->renderSection('titulo'); ?>
							</h2>
							<div class="col-sm-12">
								<ol class="breadcrumb float-sm-right">
									<li class="breadcrumb-item active"><i class="fa-solid fa-building"></i>
										<?php echo $_SESSION['empresa'] ?></li>
									<li class="breadcrumb-item active"><i class="fa-solid fa-industry"></i>
										<?php echo $_SESSION['sucursal'] ?></li>
									<li class="breadcrumb-item active"><i class="fa-solid fa-warehouse"></i>
										<?php echo $_SESSION['almacen']; ?></li>
								</ol>
							</div>
						</div>

						<!-- Page title actions -->
						<div class="col-auto ms-auto d-print-none">
							<div class="btn-list">

								<!-- Botón de Opciones -->
								<button class="btn btn-dark btn-5 d-none d-sm-inline-block"
									onclick="abrir_modal_template();">
									<i class="fas fa-exchange-alt"></i>
									&nbsp; Cambio Logueo
								</button>
								<button class="btn btn-dark btn-6 d-sm-none btn-icon" onclick="abrir_modal_template();">
									<i class="fas fa-exchange-alt"></i>
								</button>

								<a href="<?= base_url('login/salir') ?>"
									class="btn btn-primary btn-5 d-none d-sm-inline-block">
									<i class="fa-duotone fa-solid fa-right-to-bracket"></i>
									&nbsp; Cerrar sesión
								</a>
								<a href="<?= base_url('login/salir') ?>"
									class="btn btn-primary btn-6 d-sm-none btn-icon">
									<i class="fa-duotone fa-solid fa-right-to-bracket"></i>
								</a>

							</div>

						</div>
					</div>
				</div>
			</div>
			<!-- Page body -->
			<?= $this->renderSection('content'); ?>

			<!-- Modal de Opciones -->
			<div class="modal modal-blur fade" tabindex="-1" role="dialog" id="mdlcambio" name="mdlcambio">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 id="lbltitulo" name="lbltitulo" class="modal-title">Cambiar Empresa</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<div class="modal-body">
								<div class="mb-3">
									<label class="form-label"><i class="fa-solid fa-building"></i>&nbsp;Empresa</label>
									<select id="cmbempresas" name="cmbempresas" class="form-select"></select>
								</div>
								<div class="mb-3">
									<label class="form-label"><i class="fa-solid fa-industry"></i>&nbsp;Sucursal</label>
									<select id="cmbsucursal" name="cmbsucursal" class="form-select"></select>
								</div>
								<div class="mb-3">
									<label class="form-label"><i class="fa-solid fa-warehouse"></i>&nbsp;Almacen</label>
									<select id="cmbalmacen" name="cmbalmacen" class="form-select"></select>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn me-auto" data-bs-dismiss="modal">
								Cancelar
							</button>
							<button class="btn btn-danger btn-5 ms-auto" id="btnguardar" name="btnguardar"
								onclick="cambio_empresa()">
								<i class="fas fa-exchange-alt"></i> &nbsp; Cambiar
							</button>
						</div>
					</div>
				</div>
			</div>
			<footer class="footer footer-transparent d-print-none">
				<div class="container-xl">
					<div class="row text-center align-items-center flex-row-reverse">
						<div class="col-lg-auto ms-lg-auto">
							<ul class="list-inline list-inline-dots mb-0">
								<li class="list-inline-item"><a href="https://tabler.io/docs" target="_blank"
										class="link-secondary" rel="noopener">Documentation</a></li>
								<li class="list-inline-item"><a href="./license.html" class="link-secondary">License</a>
								</li>
								<li class="list-inline-item"><a href="https://github.com/tabler/tabler" target="_blank"
										class="link-secondary" rel="noopener">Source code</a></li>
								<li class="list-inline-item">
									<a href="https://github.com/sponsors/codecalm" target="_blank"
										class="link-secondary" rel="noopener">
										<!-- Download SVG icon from http://tabler.io/icons/icon/heart -->
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
											viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
											stroke-linecap="round" stroke-linejoin="round"
											class="icon text-pink icon-inline icon-4">
											<path
												d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
										</svg>
										Sponsor
									</a>
								</li>
							</ul>
						</div>
						<div class="col-12 col-lg-auto mt-3 mt-lg-0">
							<ul class="list-inline list-inline-dots mb-0">
								<li class="list-inline-item">
									Copyright &copy; 2025
									<a href="." class="link-secondary">Tabler</a>.
									All rights reserved.
								</li>
								<li class="list-inline-item">
									<a href="./changelog.html" class="link-secondary" rel="noopener">
										v1.0.0
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>
	<!-- Libs JS -->
	<script src="<?= base_url('public/dist/libs/apexcharts/dist/apexcharts.min.js') ?>" defer></script>

	<script src="<?= base_url('public/dist/libs/jsvectormap/dist/jsvectormap.min.js') ?>" defer></script>
	<script src="<?= base_url('public/dist/libs/jsvectormap/dist/maps/world.js?1738096685') ?>" defer></script>
	<script src="<?= base_url('public/dist/libs/jsvectormap/dist/maps/world-merc.js?1738096685') ?>" defer></script>
	<!-- Tabler Core -->

	<script src="<?= base_url('public/dist/js/tabler.min.js?1738096685') ?>" defer></script>
	<script src="<?= base_url('public/dist/libs/jquery/jquery-3.7.1.min.js') ?>"></script>

	<script src="<?= base_url('public/dist/js/paginas/generales.js') ?>" defer></script>

	<script src="<?= base_url('public/dist/js/demo.min.js?1738096685') ?>" defer></script>
	<script src="<?= base_url('public/dist/libs/sweetalert2/dist/sweetalert2.js') ?>"> </script>

	<script>var codalmacen = "<?= session()->get('codigoalmacen') ?? 'NL' ?>";</script>
	<script> const URL_PY = "<?= base_url(); ?>"; </script>
	<?= $this->renderSection('scripts'); ?>


</body>

</html>