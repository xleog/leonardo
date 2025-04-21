<?= $this->extend('dashboard/template.php'); ?>
<?= $this->section('titulo'); ?>
Mantenimiento de Empresa
<?= $this->endsection() ?>

<?= $this->section('estilos'); ?>

<link rel="stylesheet" href="<?= base_url('public/dist/libs/datatables/datatables.min.css') ?>" />

<?= $this->endsection() ?>

<?= $this->section('content'); ?>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Empresa</h3>
                        <div class="btn-list ms-auto">
                            <button href="#" class="btn btn-primary btn-5 d-none d-sm-inline-block" onclick="abrir_modal();">
                                <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Agregar nueva Empresa
                            </button>
                            <a href="#" class="btn btn-primary btn-6 d-sm-none btn-icon" onclick="abrir_modal();">
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
                            <table  id="tblempresa" name="tblempresa" class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th>Cod</th>
                                        <th class="w-1">RUC</th>
                                        <th>ESTADO </th>
                                        <th>DECRIPCION</th>
                                        <th>DIRECION</th>
                                        <th></th>
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

<div class="modal modal-blur fade" id="mdlempresa" name="mdlempresa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="lbltitulo" name="lbltitulo" class="modal-title">New report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="txtid" name="txtid" />
                <div class="mb-3">
                    <label class="form-label">Descripcion</label>
                    <input type="text" class="form-control" id="txtdescripcion" name="txtdescripcion" placeholder="Descripcion">
                </div>
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <label class="form-label">RUC</label>
                        <div class="input-group mb-2">
                            <select type="text" class="form-select" name="cmbtipodoc" id="cmbtipodoc">
                                <option value="RUC">RUC</option>
                            </select>
                            <input type="text" class="form-control" id="txtruc" name="txtruc" placeholder="RUC">
                            <button class="btn btn-success" type="button" id="btnsunat" name="btnsunat" onclick="sunat()">RUC</button>
                        
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">Estado</label>
                        <select class="form-select" id="cmbestado" name="cmbestado">
                            <option value="ACTIVO">ACTIVO</option>
                            <option value="INACTIVO">INACTIVO</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-lg-12">
                        <div>
                            <label class="form-label">Direccion</label>
                            <textarea class="form-control" rows="3" id="txtdireccion" name="txtdireccion"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary btn-3" data-bs-dismiss="modal">
                    Cancelar
                </a>
                <button class="btn btn-primary btn-5 ms-auto" id="btnregistrar" name="btnregistrar" onclick="registrar()">
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

<script src="<?= base_url('public/dist/js/paginas/man_empresa.js') ?>" defer></script>

<?= $this->endsection() ?>