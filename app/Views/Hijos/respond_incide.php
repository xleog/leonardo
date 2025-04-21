<?= $this->extend('dashboard/template.php'); ?>
<?= $this->section('estilos'); ?>
<link href="<?= base_url('public/dist/libs/datatables/datatables.min.css') ?>" rel="stylesheet">
<?= $this->endsection() ?>
<?= $this->section('titulo'); ?>
Responder Incidencias
<?= $this->endsection() ?>

<?= $this->section('content'); ?>
<div class="page-body">
	<div class="container-xl">
		<div class="row row-deck row-cards">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
							<h3 class="card-title">Respuestas</h3>
						<div class="btn-list ms-auto">
							<button class="btn btn-primary btn-5 d-none d-sm-inline-block" onclick="abrir_modal();">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
									<path d="M12 5l0 14" />
									<path d="M5 12l14 0" />
								</svg>
								Agregar nueva respuesta
							</button>
							<a href="#" class="btn btn-primary btn-6 d-sm-none btn-icon" onclick="abrir_modal();">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
									<path d="M12 5l0 14" />
									<path d="M5 12l14 0" />
								</svg>
							</a>

							<button class="btn btn-danger btn-5 d-none d-sm-inline-block" onclick="abrir_modal_reporte();">
                                <i class="fas fa-file-alt"></i> &nbsp;
                                Generar nuevo Reporte
                            </button>

                            <button class="btn btn-danger btn-6 d-sm-none btn-icon" onclick="abrir_modal_reporte();">
                                <i class="fas fa-file-alt"></i>
                            </button>
						</div>
					</div>

					<div class="table-responsive">
						<table class="table card-table table-vcenter text-nowrap datatable" id="tblrespuestas" name="tblrespuestas">
							<thead>
								<tr>
									<th>COD</th>
									<th>RECLAMO</th>
									<th>ENCARGADO</th>
									<th>EMPRESA</th>
									<th>RESPUESTA</th>
									<th>FECHA RESPUESTA</th>
									<th>ESTADO</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-blur fade" tabindex="-1" role="dialog" aria-hidden="true" id="mdlresponder" name="mdlresponder">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="lbltitulo" name="lbltitulo" class="modal-title">Nueva Respuesta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="txtid" name="txtid">
                <div class="mb-3">
                    <label class="form-label">Reclamo</label>
                    <input type="text" class="form-control" id="txtreclamo" name="txtreclamo" placeholder="ID del reclamo">
                </div>
                <div class="mb-3">
                    <label class="form-label">Encargado</label>
                    <input type="text" class="form-control" id="txtencargado" name="txtencargado" placeholder="ID del encargado">
                </div>
                <div class="mb-3">
                    <label class="form-label">Empresa</label>
                    <input type="text" class="form-control" id="txtempresa" name="txtempresa" placeholder="ID de la empresa">
                </div>
                <div class="mb-3">
                    <label class="form-label">Respuesta</label>
                    <textarea class="form-control" id="txtrespuesta" name="txtrespuesta" rows="3" placeholder="Escriba la respuesta"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Fecha de Respuesta</label>
                    <input type="date" class="form-control" id="txtfecharespuesta" name="txtfecharespuesta">
                </div>
                <div class="mb-3">
                    <label class="form-label">Estado</label>
                    <select class="form-select" id="cmbestado" name="cmbestado">
                        <option value="ACTIVO">ACTIVO</option>
                        <option value="INACTIVO">INACTIVO</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary btn-3" data-bs-dismiss="modal">
                    Cancelar
                </a>
                <button class="btn btn-primary btn-5 ms-auto" id="btnregistrar" name="btnregistrar" onclick="registrar()">
                    <i class="fas fa-save"></i>&nbsp;Registrar
                </button>
                <button class="btn btn-danger btn-5 ms-auto d-none" id="btneditar" name="btneditar" onclick="editar()">
                    <i class="fas fa-pencil-alt"></i>&nbsp;Editar
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" tabindex="-1" role="dialog" aria-hidden="true" id="mdlreporte" name="mdlreporte">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="lbltitulo" name="lbltitulo" class="modal-title">Nuevo Reporte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="dtpfechainicio" name="dtpfechainicio">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label">Fecha de Fin</label>
                            <input type="date" class="form-control" id="dtpfin" name="dtpfin">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary btn-3" data-bs-dismiss="modal">
                    Cancelar
                </a>
                <button class="btn btn-primary btn-5 ms-auto" id="btnregistrar" name="btnregistrar"
                    onclick="ver_reportes_por_fecha()">
                    <i class="fas fa-save"></i>&nbsp;Generar Reporte
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->endsection() ?>

<?= $this->section('scripts'); ?>
<script src="<?= base_url('public/dist/js/paginas/respond_incide.js') ?>" defer></script>
<script src="<?= base_url('public/dist/libs/datatables/datatables.min.js') ?>"></script>
<?= $this->endsection() ?>