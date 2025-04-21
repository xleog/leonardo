<?= $this->extend('dashboard/template.php'); ?>

<?= $this->section('estilos'); ?>

<link rel="stylesheet" href="<?= base_url('public/dist/libs/datatables/datatables.min.css') ?>" />

<?= $this->endsection() ?>

<?= $this->section('titulo'); ?>
Mantenimiento de Usuarios
<?= $this->endsection() ?>

<?= $this->section('content'); ?>
<div class="page-body">
	<div class="container-xl">
		<div class="row row-deck row-cards">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Usuarios</h3>
						<div class="btn-list ms-auto">
							<button class="btn btn-primary btn-5 d-none d-sm-inline-block" onclick="abrir_modal();">
								<!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
									<path d="M12 5l0 14" />
									<path d="M5 12l14 0" />
								</svg>
								Agregar nuevo Usuario
							</button>
							<a href="#" class="btn btn-primary btn-6 d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
								<!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
									<path d="M12 5l0 14" />
									<path d="M5 12l14 0" />
								</svg>
							</a>
						</div>
					</div>


					<div class="card-body">
						<div class="table-responsive">
							<table class="table" id="tblusuarios" name="tblusuarios">
								<thead>
									<tr>
										<th>ID</th>
										<th>NOMBRE</th>
										<th>CLAVE</th>
										<th>ESTADO</th>
										<th>PERFIL</th>
										<th>IDPERSONAL</th>
										<th></th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-blur fade" tabindex="-1" role="dialog"  id="mdlusuarios" name="mdlusuarios" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 id="lbltitulo" name="lbltitulo" class="modal-title">New report</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="mb-3">
					<label class="form-label">Usuario</label>
					<input type="text" class="form-control" name="txtusuario" id="txtusuario" placeholder="NOMBRE">
				</div>

				<div class="row">
					<div class="col-lg-8">
						<div class="mb-3">
							<label class="form-label">ID</label>
							<div class="input-group input-group-flat">

								<input type="text" class="form-control" name="txtid" id="txtid"  autocomplete="off">
							</div>
						</div>
						
					</div>
					<div class="col-lg-4">
						<div class="mb-3">
							<label class="form-label">Estado</label>
							<select class="form-select" id="cmdestado" name="cmdestado">
								<option value="ACTIVO">ACTIVO</option>
								<option value="INACTIVO">INACTIVO</option>
							</select>
						</div>
					</div>
					<div class="mb-3"><input type="hidden" id="txtcod" name="txtcod" />
							<label class="form-label">Clave</label>
							<div class="input-group input-group-flat">
								<input type="text" class="form-control"  id="txtclave" name="txtclave" >
							</div>
						</div>
						<div class="mb-3">
							<label class="form-label">Perfil</label>
							<div class="input-group input-group-flat">

								<input type="text" class="form-control "  id="txtperfil" name="txtperfil">
							</div>
						</div>
						<div class="mb-3">
							<label class="form-label">ID PERSONAL</label>
							<div class="input-group input-group-flat">

								<input type="text" class="form-control" name="txtidpersonal" id="txtidpersonal"  autocomplete="off">
							</div>
						</div>
						
				</div>
			</div>

			<div class="modal-footer">
				<a href="#" class="btn btn-link link-secondary btn-3" data-bs-dismiss="modal">
					Cancelar
				</a>
				<button class="btn btn-primary btn-5 ms-auto"  id="btnregistrar" name="btnregistrar" onclick="registrar()">												
												<i class="fa-solid fa-floppy-disk"></i>&nbsp;Registrar
				</button>
				<button class="btn btn-danger btn-5 ms-auto" id="btneditar" name="btneditar" onclick="editar()">												
												<i class="fas fa-pencil-alt"></i>&nbsp;Editar
				</button>
			</div>
		</div>
	</div>
</div>
<?= $this->endsection() ?>

<?= $this->section('scripts'); ?>

<script src="<?= base_url('public/dist/libs/datatables/datatables.min.js') ?>" defer></script>
<script src="<?= base_url('public/dist/js/paginas/man_usuarios.js') ?>"></script>
<?= $this->endsection() ?>