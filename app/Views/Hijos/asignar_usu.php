<?= $this->extend('dashboard/template.php'); ?>
<?= $this->section('titulo'); ?>
Asignar Usuarios
<?= $this->endsection() ?>

<?= $this->section('content'); ?>
<div class="page-body">
	<div class="container-xl">
		<div class="row row-deck row-cards">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
							<h3 class="card-title">Usignaciones</h3>
						<div class="btn-list ms-auto">
							<button class="btn btn-primary btn-5 d-none d-sm-inline-block" onclick="abrir_modal();">
								<!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
									<path d="M12 5l0 14" />
									<path d="M5 12l14 0" />
								</svg>
								Agregar nueva Asignacion
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

					<div class="table-responsive">
						<table class="table card-table table-vcenter text-nowrap datatable" id="tblusuarios" name="tblusuarios">
							<thead>
								<tr>
									<th class="w-1"><input class="form-check-input m-0 align-middle"
											type="checkbox" aria-label="Select all invoices"></th>
									<th class="w-1">COD
										<!-- Download SVG icon from http://tabler.io/icons/icon/chevron-up -->
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
											viewBox="0 0 24 24" fill="none" stroke="currentColor"
											stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
											class="icon icon-sm icon-thick icon-2">
											<path d="M6 15l6 -6l6 6" />
										</svg>
									</th>
									<th>Nombre</th>
									<th>Password</th>
									<th>Estado</th>
									<th>Perfil</th>
									<th>Status</th>
									<th>Price</th>
									<th></th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
					<div class="card-footer d-flex align-items-center">
						<p class="m-0 text-secondary">Showing <span>1</span> to <span>8</span> of
							<span>16</span> entries
						</p>
						<ul class="pagination m-0 ms-auto">
							<li class="page-item disabled">
								<a class="page-link" href="#" tabindex="-1" aria-disabled="true">
									<!-- Download SVG icon from http://tabler.io/icons/icon/chevron-left -->
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
										viewBox="0 0 24 24" fill="none" stroke="currentColor"
										stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
										class="icon icon-1">
										<path d="M15 6l-6 6l6 6" />
									</svg>
									prev
								</a>
							</li>
							<li class="page-item"><a class="page-link" href="#">1</a></li>
							<li class="page-item active"><a class="page-link" href="#">2</a></li>
							<li class="page-item"><a class="page-link" href="#">3</a></li>
							<li class="page-item"><a class="page-link" href="#">4</a></li>
							<li class="page-item"><a class="page-link" href="#">5</a></li>
							<li class="page-item">
								<a class="page-link" href="#">
									next
									<!-- Download SVG icon from http://tabler.io/icons/icon/chevron-right -->
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
										viewBox="0 0 24 24" fill="none" stroke="currentColor"
										stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
										class="icon icon-1">
										<path d="M9 6l6 6l-6 6" />
									</svg>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-blur fade" tabindex="-1" role="dialog" aria-hidden="true" id="mdlasignacion" name="mdlasignacion">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 id="lbltitulo" name="lbltitulo" class="modal-title">New report</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="mb-3">
					<label class="form-label">Name</label>
					<input type="text" class="form-control" name="example-text-input" placeholder="Your report name">
				</div>
				<label class="form-label">Report type</label>
				<div class="form-selectgroup-boxes row mb-3">
					<div class="col-lg-6">
						<label class="form-selectgroup-item">
							<input type="radio" name="report-type" value="1" class="form-selectgroup-input" checked>
							<span class="form-selectgroup-label d-flex align-items-center p-3">
								<span class="me-3">
									<span class="form-selectgroup-check"></span>
								</span>
								<span class="form-selectgroup-label-content">
									<span class="form-selectgroup-title strong mb-1">Simple</span>
									<span class="d-block text-secondary">Provide only basic data needed for the report</span>
								</span>
							</span>
						</label>
					</div>
					<div class="col-lg-6">
						<label class="form-selectgroup-item">
							<input type="radio" name="report-type" value="1" class="form-selectgroup-input">
							<span class="form-selectgroup-label d-flex align-items-center p-3">
								<span class="me-3">
									<span class="form-selectgroup-check"></span>
								</span>
								<span class="form-selectgroup-label-content">
									<span class="form-selectgroup-title strong mb-1">Advanced</span>
									<span class="d-block text-secondary">Insert charts and additional advanced analyses to be inserted in the report</span>
								</span>
							</span>
						</label>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-8">
						<div class="mb-3">
							<label class="form-label">Report url</label>
							<div class="input-group input-group-flat">
								<span class="input-group-text">
									https://tabler.io/reports/
								</span>
								<input type="text" class="form-control ps-0" value="report-01" autocomplete="off">
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="mb-3">
							<label class="form-label">Visibility</label>
							<select class="form-select">
								<option value="1" selected>Private</option>
								<option value="2">Public</option>
								<option value="3">Hidden</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="mb-3">
							<label class="form-label">Client name</label>
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="col-lg-6">
						<div class="mb-3">
							<label class="form-label">Reporting period</label>
							<input type="date" class="form-control">
						</div>
					</div>
					<div class="col-lg-12">
						<div>
							<label class="form-label">Additional information</label>
							<textarea class="form-control" rows="3"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-link link-secondary btn-3" data-bs-dismiss="modal">
					Cancel
				</a>
				<a href="#" class="btn btn-primary btn-5 ms-auto" data-bs-dismiss="modal">
					<!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
						<path d="M12 5l0 14" />
						<path d="M5 12l14 0" />
					</svg>
					Create new report
				</a>
			</div>
		</div>
	</div>
</div>
<?= $this->endsection() ?>

<?= $this->section('scripts'); ?>

<script src="<?= base_url('public/dist/js/paginas/asignar_usu.js') ?>" defer></script>


<script> const baseURL = "<?= base_url(); ?>"; </script>

<?= $this->endsection() ?>