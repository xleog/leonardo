<?php
namespace App\Models;

use CodeIgniter\Model;

class MantPersonalModel extends Model
{
    protected $table = 'personal';
    protected $primaryKey = 'idpersonal';
    protected $allowedFields = ['idpersonal', 'documento_identidad', 'estado', 'fecha_nac', 'email', 'nombre'];

    public function traer_al_personal()
    {
        return $this->select('idpersonal,documento_identidad, estado, fecha_nac, email, nombre')
            ->orderBy('nombre', 'ASC')
            ->findAll();
    }

    public function traer_datos_por_cod($cod)
    {
        return $this->select('idpersonal, documento_identidad, estado, fecha_nac, email, nombre')
            ->where('idpersonal', $cod)
            ->first();
    }

    public function exists($documento_identidad, $id = null)
    {
        $query = $this->where('documento_identidad', $documento_identidad);

        // Si se proporciona un ID, excluimos ese registro
        if ($id !== null) {
            $query->where('idpersonal !=', $id);
        }

        return $query->first() !== null;
    }

    public function registrar_emailcliente($xmlContent)
    {
        try {

            $sql = 'CALL REG_personal(?,@mensaje)';
            $this->db->query($sql, [$xmlContent]);

            $result = $this->db->query("SELECT @mensaje as mensaje");
            $mensaje = $result->getRow()->mensaje;

            if (strpos($mensaje, 'ERROR:') !== false) {
                return $mensaje;
            }
            return $mensaje;

        } catch (\mysqli_sql_exception $e) {
            log_message('error', 'Error al registrar el usuario:' . $e->getMessage());
            return 'Error:' . $e->getMessage();
        } catch (\Exception $e) {
            log_message('error', 'Error generico:' . $e->getMessage());
            return 'Error:' . $e->getMessage();
        }
    }


}

?>