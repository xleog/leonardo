<?php
$this->extend('dashboard/template.php'); ?>
<?= $this->section('estilos'); ?>
<link href="<?= base_url('public/dist/libs/datatables/datatables.min.css') ?>" rel="stylesheet">

<?= $this->endsection() ?>

<?= $this->section('titulo'); ?>
Mantenimiento de Clientes
<?= $this->endsection() ?>

<?= $this->section('content'); ?>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Clientes</h3>
                        <div class="btn-list ms-auto">
                            <button href="#" class="btn btn-primary btn-5 d-none d-sm-inline-block"
                                onclick="abrir_modal();">
                                <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-2">
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Agregar nuevo cliente
                            </button>
                            <a href="#" class="btn btn-primary btn-6 d-sm-none btn-icon" data-bs-toggle="modal"
                                onclick="abrir_modal();">
                                <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-2">
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="tblclientes" name="tblclientes">
                                <thead>
                                    <tr>
                                        <th class="w-10 text-center">Cod</th>
                                        <th class="w-40">Documento</th>
                                        <th class="w-20">Nombre</th>
                                        <th class="w-20">Dirección</th>
                                        <th class="w-10">F. Nac</th>
                                        <th class="w-10">Nacionalidad</th>
                                        <th class="w-10">Estado</th>
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
</div>

<div class="modal modal-blur fade" id="mdl_clientes" name="mdl_clientes" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="lbltitulo" name="lbltitulo" class="modal-title">New report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3"><input type="hidden" id="txtid" name="txtid" />
                    <label class="form-label">Tipo Cliente</label>
                    <select type="text" class="form-control" id="cmbtipocliente" name="cmbtipocliente">
                        <option value="2">DNI</option>
                        <option value="1">RUC</option>
                    </select>
                </div>


                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="txtnombre" name="txtnombre" placeholder="Nombre">
                </div>

                <div class="row mb-3">
                <div class="col-lg-6">
                        <label class="form-label">Documento</label>
                        <input type="text" class="form-control" id="txtdocumento" name="txtdocumento"
                            placeholder="Documento">
                </div>

                <div class="col-lg-6">
                        <label class="form-label">Estado</label>
                        <select class="form-select" id="cmbestado" name="cmbestado">
                            <option value="ACTIVO">ACTIVO</option>
                            <option value="INACTIVO">INACTIVO</option>
                        </select>
                    </div>

                </div>

                <div class="row mb-3">
                    <div class="col-lg-6">
                        <label class="form-label">F. Nac.</label>
                        <input type="date" class="form-control" id="dtpfecha" name="dtpfecha"
                            value="<?php echo date('Y-m-d'); ?>" />
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">Nacionalidad</label>
                        <select class="form-select" id="cmbnacionalidad" name="cmbnacionalidad">
                            <option value="PERUANA">PERUANA</option>
                            <option value="EXTRANJERA">EXTRANJERA</option>
                        </select>
                    </div>

                </div>

                <div class="col-lg-12">
                    <div class="row mb-3">
                        <div>
                            <label class="form-label">Dirección</label>
                            <textarea class="form-control" rows="3" id="txtdireccion" name="txtdireccion"></textarea>
                        </div>
                    </div>

                </div>

                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-label">Departamento</label>
                            <select class="form-select departamento" id="cmbdepartamento" name="cmbdepartamento">
                                <?php foreach ($ubigeo as $ubigeos): ?>
                                    <option value="<?= esc($ubigeos['departamento']); ?>">
                                        <?= esc($ubigeos['departamento']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Provincia</label>
                            <select class="form-select provincia" id="cmbprovincia" name="cmbprovincia"></select>
                        </div>

                        <div class="col-lg-3">
                            <label class="form-label">Distrito</label>
                            <select class="form-select distrito" id="cmbdistrito" name="cmbdistrito"></select>
                        </div>

                        <div class="col-lg-3">
                            <label class="form-label">Ubigeo</label>
                            <input type="text" class="form-control" id="txtubigeo" name="txtubigeo" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-vcenter" id="tblemailclientes" name="tblemailclientes">
                                    <thead>
                                        <tr>
                                            <th>EMAIL</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control email_cliente"
                                                    id="txtemail_cliente" name="txtemail_cliente" placeholder="Email">
                                            </td>
                                            <td>
                                                <button class="btn btn-success" id="btnemailcliente"
                                                    name="btnemailcliente" type="button" onclick="agregar_fila()">
                                                    <i class="fa-solid fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary btn-3" data-bs-dismiss="modal">
                    Cancelar
                </a>
                <button class="btn btn-primary btn-5 ms-auto" id="btnregistrar" name="btnregistrar"
                    onclick="registrar_emailclientes()">
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

<?= $this->section('scripts') ?>
<script src="<?= base_url('public/dist/libs/datatables/datatables.min.js') ?>"></script>
<script src="<?= base_url('public/dist/js/paginas/mantclientes.js') ?>" defer></script>
<?= $this->endsection() ?>