<?php
namespace App\Models;

use CodeIgniter\Model;

class BarrasPerfilModel extends Model
{
    protected $table      = 'barras_perfil';
    protected $primaryKey = 'idbarras_perfil';
    protected $allowedFields = ['idbarras_perfil','descripcion', 'padre', 'ruta', 'logo', 'perfil','acceso'];
    public function getbarraperfilxperfil_padre($perfil){
        return $this->where('perfil',$perfil)
                    ->where('padre',0)
                    ->findAll();
    }

    public function geturlsxperfil($perfil)
    {
        return $this->where('perfil',$perfil)
                    ->where('acceso','SI')
                    ->whereNotIn('padre',[0])
                    ->findAll();
    }
    public function geturlsxperfil_aside($perfil)
    {
        return $this->where('perfil',$perfil)
                    ->where('acceso','SI')
                    ->findAll();
    }

    public function get_formularios_x_padre($padre){
        return $this->where('padre',$padre)
                    ->findAll();
    }

    public function registra_accceso($xmlContent)
    {      
        try {
            // Ejecutar el stored procedure
            $sql = 'CALL REGISTRAR_ACCESO_MODULO(?, @mensaje)';
            $this->db->query($sql, [$xmlContent]);
    
            // Obtener el mensaje de retorno
            $result = $this->db->query("SELECT @mensaje AS mensaje");
            $mensaje = $result->getRow()->mensaje;
    
            // Verificar si hay error en el mensaje del stored procedure
            if (strpos($mensaje, 'ERROR:') !== false) {
                // Si el mensaje contiene 'ERROR:', devolverlo
                return $mensaje;
            }
    
            // Si todo va bien, devolver el mensaje de éxito
            return $mensaje;
    
        } catch (\mysqli_sql_exception $e) {
            // Capturar y registrar el error específico de MySQL
            log_message('critical', 'Error al registrar el acceso: ' . $e->getMessage());
            return 'ERROR: ' . $e->getMessage(); // Devuelve el mensaje de error
        } catch (\Exception $e) {
            // Capturar errores genéricos
            log_message('critical', 'Error genérico: ' . $e->getMessage());
            return 'ERROR: ' . $e->getMessage();
        }
    }

}