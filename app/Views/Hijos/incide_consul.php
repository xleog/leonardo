<?= $this->extend('dashboard/template.php'); ?>

<?= $this->section('estilos'); ?>
<link href="<?= base_url('public/dist/libs/datatables/datatables.min.css') ?>" rel="stylesheet">
<?= $this->endsection() ?>

<?= $this->section('titulo'); ?>
Consultar Incidencia
<?= $this->endsection() ?>

<?= $this->section('content'); ?>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Incidencias</h3>
                        <div class="btn-list ms-auto">
                            <button class="btn btn-primary btn-5 d-none d-sm-inline-block" onclick="abrir_modal();">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-2">
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Agregar nueva Incidencia
                            </button>
                            <button class="btn btn-primary btn-6 d-sm-none btn-icon" onclick="abrir_modal();">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-2">
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                            </button>
                            <button class="btn btn-danger btn-5 d-none d-sm-inline-block"
                                onclick="abrir_modal_reporte();">
                                <i class="fas fa-file-alt"></i> &nbsp;
                                Generar nuevo Reporte
                            </button>

                            <button class="btn btn-danger btn-6 d-sm-none btn-icon" onclick="abrir_modal_reporte();">
                                <i class="fas fa-file-alt"></i>
                            </button>
                        </div>
                    </div>



                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable" id="tblincidencias"
                            name="tblincidencias">
                            <thead>
                                <tr>
                                    <th>COD</th>
                                    <th>CLIENTE</th>
                                    <th>DESCRIPCIÓN</th>
                                    <th>FECHA RECLAMO</th>
                                    <th>ESTADO</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" tabindex="-1" role="dialog" aria-hidden="true" id="mdlincidencias"
    name="mdlincidencias">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="lbltitulo" name="lbltitulo" class="modal-title">Nueva Incidencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="txtid" name="txtid">
                <div class="mb-3">
                    <label class="form-label">Cliente</label>
                    <input type="hidden" id="txtidcli" name="txtidcli" />
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" id="txtnomcliente" name="txtnomcliente" placeholder="Seleccionar cliente" disabled>
                        <button class="btn btn-danger" id="btnelecliente" name="btnelecliente" onclick="elegir_cliente()" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea class="form-control" id="txtdescripcion" name="txtdescripcion" rows="3"
                        placeholder="Descripción del reclamo"></textarea>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label">Fecha Reclamo</label>
                            <input type="date" class="form-control" id="txtfecha" name="txtfecha">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label">Estado</label>
                            <select class="form-select" id="cmbestado" name="cmbestado">
                                <option value="PENDIENTE">PENDIENTE</option>
                                <option value="ATENDIDO">ATENDIDO</option>
                                <option value="CERRADO">CERRADO</option>
                            </select>
                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary btn-3" data-bs-dismiss="modal">
                    Cancelar
                </a>
                <button class="btn btn-primary btn-5 ms-auto" id="btnregistrar" name="btnregistrar"
                    onclick="registrar()">
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

<div class="modal modal-blur fade" tabindex="-1" role="dialog" id="mdlelcliente" name="mdlelcliente">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="lbltitulo" name="lbltitulo" class="modal-title">Elegir Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Buscador -->
                        <div class="input-group mb-3">
                            <input type="text" id="buscador" class="form-control" placeholder="Escribe al menos 3 letras..." autocomplete="off">
                            <button class="btn btn-outline-primary" type="button" disabled>
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <!-- Resultados -->
                        <ul id="resultados" class="list-group"></ul>
                        <!-- Botón "Cargar más" -->
                        <button id="cargarMas" class="btn btn-secondary btn-sm mt-2 w-100" style="display: none;">
                            <i class="fas fa-sync-alt"></i> Cargar más
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?= $this->endsection() ?>

<?= $this->section('scripts'); ?>
<script src="<?= base_url('public/dist/js/paginas/incide_consul.js') ?>"></script>
<script src="<?= base_url('public/dist/libs/datatables/datatables.min.js') ?>"></script>
<?= $this->endsection() ?>