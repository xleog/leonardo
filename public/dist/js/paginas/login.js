$(document).ready(function () {
   /*  traer_sucursales_x_empresa();
      $("#cmbempresa").change(function (e) { 
          traer_sucursales_x_empresa();
        
      });
      $("#cmbsucursal").change(function (e) { 
          traer_almacenes_x_sucursal();
      }); */
      $('#txtpassword').keyup(function(e){
        if(e.keyCode == 13)
        {
            loguear_sistema();
        }
      }); 
  });

  
  function loguear_sistema() {
      var usu = $('#cmbusuario').val()
      var pass = $('#txtpassword').val()
     /*  var empresa=$('#cmbempresa').val();
      var sucu=$('#cmbsucursal').val();
      var alma=$('#cmbalmacen').val(); */
      if (pass==='') {
          Swal.fire({
              title:"SIGISTRANS",
              text: "Falta ingresar contraseña!",
              icon: "error",
              showCancelButton: false,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Ok"
            }).then((result) => {
              if (result.isConfirmed) {
                  var passwordField = $('#txtpassword');
  
                  // Enfocar el campo inmediatamente
                  passwordField.focus();
  
                  // Mantener el focus por más tiempo (vuelve a enfocar después de 300ms)
                  setTimeout(function() {
                      passwordField.focus();
                  }, 300);
              }
            });        
      }
      else{
          var parametros='pssw='+pass+'&idusu='+usu;
  
          console.log(parametros)
          $.ajax({
              type: "POST",
              url: URL_PY+'login/ingresar',
              data: parametros,
              success: function (response) {
                 /*  console.log(response); */
                  if (response.mensaje) {
                      Swal.fire({
                          icon: "error",
                          title: "INICIO DE SESION",
                          text: response.mensaje
                      });
                      } else {
                          window.location.href = 'dashboard';
                      }
              }
          });
      }
  }
  
  $(document).ready(function () {
      $("#togglePassword").click(function(e) {
          e.preventDefault();
          var $passwordInput = $("#txtpassword");
          var $eyeOpen = $("#eye-open");
          var $eyeClosed = $("#eye-closed");
          
          if ($passwordInput.attr("type") === "password") {
            $passwordInput.attr("type", "text");
            $eyeOpen.hide();
            $eyeClosed.show();
          } else {
            $passwordInput.attr("type", "password");
            $eyeOpen.show();
            $eyeClosed.hide();
          }
        });
  });
  
  function traer_sucursales_x_empresa() {
  
    var codempresa = $('#cmbempresa').val();
    var parametros = 'id='+ codempresa;
  
   
    $.ajax({
        type: "GET",
        url: URL_PY + 'login/select_suc',
        data: parametros,
        success: function (response) {
            // Asegurar que response sea un array válido
            var sucursales = response[0]; 
  
            // Limpiar el select antes de agregar nuevas opciones
            $('#cmbsucursal').empty();
  
            // Verificar si hay sucursales antes de recorrer
            if (Array.isArray(sucursales)) {
                sucursales.forEach(function (sucursal) {
                    $('#cmbsucursal').append('<option value="' + sucursal.idsucursal + '">' + sucursal.descripcion + '</option>');
                });
            }
            traer_almacenes_x_sucursal();
        }
    });
  }
  
  function traer_almacenes_x_sucursal() {
  
    var codalmacen = $('#cmbsucursal').val();
    var parametros = 'id='+ codalmacen;
  
   
    $.ajax({
        type: "GET",
        url: URL_PY + 'login/select_alm',
        data: parametros,
        success: function (response) {
            // Asegurar que response sea un array válido
            var almacenes = response[0]; 
  
            // Limpiar el select antes de agregar nuevas opciones
            $('#cmbalmacen').empty();
  
            // Verificar si hay sucursales antes de recorrer
            if (Array.isArray(almacenes)) {
                almacenes.forEach(function (almacenes) {
                    $('#cmbalmacen').append('<option value="' + almacenes.idalmacen + '">' + almacenes.descripcion + '</option>');
                });
            }
        }
    });
  }

