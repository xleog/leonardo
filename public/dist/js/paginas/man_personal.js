var table = "";

$(document).ready(function () {
    cargar_personal();
});


function abrir_modal() {
    limpiar();
    $('#lbltitulo').html('Nuevo Personal');
    $('#btnregistrar').removeClass('d-none');
    $('#btneditar').addClass('d-none');
    $('#mdl_personal').modal('show');
    $('#tblusuariospersonal').closest('.col-lg-12').show();

}


function limpiar() {
    $('#txtdocumento').val('');
    $('#txtnombre').val('');
    $('#cmbestado').val('ACTIVO');
    $('#dtpfecha').val('');
    $('#txtemail').val('');
}

function cargar_personal() 
{
    const url = URL_PY + 'datatables/dtpersonal';    
    table = $('#tblpersonal').DataTable({
        "destroy": true,
        "language": Español,
        "autoWidth": true,
        "responsive": true,
        "ajax": {
            'method': 'GET',
            'url': url,
            'dataSrc': function (json) {
                ////console.log(json); // Verifica que los datos sean correctos
                return json.data; 
            }
        },
        "columns": [
            {"data": "idpersonal", "visible": false},
            {"data": "documento_identidad"},           
            {"data": "nombre"},
            {"data": "fecha_nac"},
            {"data": "estado"},
            {"data": "email"},

            {
                "data": null,
                "orderable": false, // Deshabilitar el ordenamiento en esta columna
                "render": function(data, type, row) {
                    return `<button class="btn btn-2 btn-warning btn-pill w-80" onclick="mostrarDatos(${data.idpersonal})">
                                <i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;EDITAR 
                            </button>`;
                }
            }
        ]
    });  
}

function mostrarDatos(cod) {
    var parametros = 'cod='+cod;
    const url = URL_PY + 'devdat/personal';  
    $.ajax({
        type: "GET",
        url: url,
        data: parametros,
        success: function (response) {
            //console.log( response[0]);
            $('#txtid').val(cod);
            $('#btnregistrar').addClass('d-none');
            $('#btneditar').removeClass('d-none');
            $('#txtdocumento').val(response[0].documento_identidad);
            $('#txtnombre').val(response[0].nombre);
            $('#cmbestado').val(response[0].estado);
            $('#dtpfecha').val(response[0].fecha_nac);
            $('#txtemail').val(response[0].email);
            $('#tblusuariospersonal').closest('.col-lg-12').hide();

        } 
    });
    $('#lbltitulo').html('Editar Cliente');
    $('#mdl_personal').modal('show');
}


function registrar() {

    var parametros = 'nombre='+$('#txtnombre').val()+
        '&documento_identidad='+$('#txtdocumento').val()+
        '&fecha_nac='+$('#dtpfecha').val()+
        '&email='+$('#txtemail').val()+
        '&estado='+$('#cmbestado').val()

    //console.log("Datos a enviar:", parametros); // 🔍 Verifica en la consola del navegador

    $.ajax({
        type: "POST",
        url: URL_PY + 'personal/registrar',
        data: parametros,
        success: function (response) {
            if (response.error) {
                Swal.fire({
                      icon: "error",
                      title: 'REGISTRO DE PERSONAL',
                      text: response.error
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'REGISTRO DE PERSONAL',
                    text: response.message,            
                }).then(function() {
                    var paginaActual = table.page.info().page;
                    table.ajax.reload();
                    setTimeout(function () {
                        table.page(paginaActual).draw('page');
                    }, 800);                          
                    limpiar();
                    $('#mdl_personal').modal('hide');
                });     
            }
        }
    });
}

function editar() {

    var parametros='nombre='+$('#txtnombre').val()+
        '&documento_identidad='+$('#txtdocumento').val()+
        '&fecha_nac='+$('#dtpfecha').val()+
        '&email='+$('#txtemail').val()+
        '&estado='+$('#cmbestado').val()+
        '&cod='+$('#txtid').val()

    $.ajax({
        type: "POST",
        url: URL_PY + 'personal/editar',
        data: parametros,        
        success: function (response) {
            if (response.error) {
                Swal.fire({
                      icon: "error",
                      title: 'EDICIÓN DE PERSONAL',
                      text: response.error
                });
               
            }
            else
            {
                Swal.fire({
                    icon: 'success',
                    title: 'EDICIÓN DE PERSONAL',
                    text: response.message,            
                    }).then(function() {
                      var paginaActual = table.page.info().page;
                      table.ajax.reload();
                      setTimeout(function () {
                          table.page(paginaActual).draw('page');
                      }, 800);                          
                     limpiar();
                     $('#mdl_personal').modal('hide');
            });     
            }
        }
    });
}

function reniec(){
    $.ajaxblock();
    var parametros='doc='+$('#txtdocumento').val();
   $.ajax({
    type: "GET",
    url:  URL_PY + 'personal/reniec',
    data:parametros,
    success: function (response) {
        console.log(response);
        $.ajaxunblock();
        $('#txtnombre').val(response.nombres.trim()+' '+response.apellido_paterno +' '+ response.apellido_materno);
        $('#dtpfecha').val(response.fecha_nacimiento);
    }
   });
}


