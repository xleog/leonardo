<?php
namespace App\Controllers;
use App\Models\ClientesModel;
use App\Models\IncideConsulModel;
use CodeIgniter\Controller;

class IncideConsulController extends Controller
{
    public function index()
    {
        $Clientes=new ClientesModel();
        $data['Clientes']= $Clientes->clientes_activos();
        return view('Views/Hijos/incide_consul.php', $data);
    }

    public function traer_incidencias()
    {
        $model = new IncideConsulModel();
        $data = $model->traer_incidencias();
        return $this->response->setJSON(['data' => $data]);
    }

    public function get_datos_x_cod()
    {
        $model = new IncideConsulModel();
        $cod = $this->request->getGet('cod');
        $data = $model->traer_incidencias_x_cod($cod);
        return $this->response->setJSON([$data]);
    }

    public function insertar()
    {
        $model = new IncideConsulModel();
        
        $data = [
            'idclientes' => $this->request->getPost('idclientes'),
            'descripcion' => $this->request->getPost('descripcion'),
            'fecha_reclamo' => $this->request->getPost('fecha_reclamo'),
            'estado' => $this->request->getPost('estado')
        ];

        try {
            $model->insert($data);
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Incidencia registrada correctamente'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => 'Error al registrar la incidencia: ' . $e->getMessage()
            ]);
        }
    }

    public function update()
    {
        $model = new IncideConsulModel();
        $id = $this->request->getPost('cod');
        
        $data = [
            'idclientes' => $this->request->getPost('idclientes'),
            'descripcion' => $this->request->getPost('descripcion'),
            'fecha_reclamo' => $this->request->getPost('fecha_reclamo'),
            'estado' => $this->request->getPost('estado')
        ];

        try {
            if ($model->update($id, $data)) {
                return $this->response->setJSON([
                    'success' => true, 
                    'message' => 'Incidencia actualizada correctamente'
                ]);
            } else {
                return $this->response->setJSON([
                    'error' => 'No se encontró la incidencia'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => 'Error al actualizar la incidencia: ' . $e->getMessage()
            ]);
        }
    }

    public function rptgeneral()
    {
        require_once(APPPATH . 'Libraries/fpdf/fpdf.php');

        // Obtener los parámetros
        $inicio = $this->request->getPost('i');
        $fin = $this->request->getPost('f');
        $nombreusuario = session()->get('nombreusuariocorto');
        $nombresucursal = session()->get('nombresucursal');
        $nombrealmacen = session()->get('nombrealmacen');
        $codempresa = session()->get('codempresa');
        log_message('error','INICIO:'.$inicio);

        $KardexModel = new IncideConsulModel();
        $articulos = $KardexModel->ver_articulos_fecha($inicio, $fin, $codempresa);

        // Crear el objeto PDF extendiendo con clase anónima para agregar encabezado y pie de página
        $pdf = new class($inicio, $fin, $nombreusuario, $nombresucursal, $nombrealmacen) extends \FPDF {
            private $inicio;
            private $fin;
            private $nombreusuario;
            private $nombresucursal;
            private $nombrealmacen;

            public function __construct($inicio, $fin, $nombreusuario, $nombresucursal, $nombrealmacen)
            {
                parent::__construct();
                $this->inicio = (new \DateTime($inicio))->format('d/m/Y');
                $this->fin = (new \DateTime($fin))->format('d/m/Y');
                $this->nombreusuario = $nombreusuario;
                $this->nombresucursal = $nombresucursal;
                $this->nombrealmacen = $nombrealmacen;
            }

            // Encabezado
            function Header()
            {
                // Logo (si existe)
                // $this->Image('ruta/al/logo.png', 10, 6, 30);
                
                // Línea superior
                $this->SetLineWidth(0.5);
                $this->SetDrawColor(26, 137, 164);
                $this->Line(10, 5, 287, 5);
                
                // Título del reporte
                $this->SetFont('Arial', 'B', 14);
                $this->SetTextColor(26, 137, 164);
                $this->Cell(0, 15, utf8_decode('REPORTE DE INCIDENCIAS'), 0, 1, 'C');
                
                // Información del reporte
                $this->SetFont('Arial', 'B', 10);
                $this->SetTextColor(0, 0, 0);
                $this->Cell(0, 6, utf8_decode('Período: ') . $this->inicio . ' - ' . $this->fin, 0, 1, 'C');
                
                // Información de sucursal y almacén
                $this->SetFont('Arial', '', 9);
                $this->Cell(0, 5, utf8_decode('Sucursal: ') . $this->nombresucursal . ' | ' . utf8_decode('Almacén: ') . $this->nombrealmacen, 0, 1, 'C');
                
                // Información de usuario y fecha
                $this->SetFont('Arial', 'I', 8);
                $this->Cell(0, 5, utf8_decode('Generado por: ') . $this->nombreusuario . ' | ' . utf8_decode('Fecha: ') . date("d/m/Y H:i"), 0, 1, 'R');
                
                // Línea inferior del encabezado
                $this->SetLineWidth(0.5);
                $this->SetDrawColor(26, 137, 164);
                $this->Line(10, $this->GetY(), 287, $this->GetY());
                
                // Espacio después del encabezado
                $this->Ln(5);
            }

            // Pie de página
            function Footer()
            {
                // Línea superior del pie de página
                $this->SetLineWidth(0.5);
                $this->SetDrawColor(26, 137, 164);
                $this->Line(10, $this->GetY(), 287, $this->GetY());
                
                // Posición a 1.5 cm del final
                $this->SetY(-15);
                
                // Número de página
                $this->SetFont('Arial', 'I', 8);
                $this->SetTextColor(26, 137, 164);
                $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
            }
            
            var $widths;
            var $aligns;

            function SetWidths($w)
            {
                //Set the array of column widths
                $this->widths = $w;
            }

            function SetAligns($a)
            {
                //Set the array of column alignments
                $this->aligns = $a;
            }

            function Row($data)
            {
                //Calculate the height of the row
                $nb = 0;
                for ($i = 0; $i < count($data); $i++)
                    $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
                $h = 5 * $nb;
                //Issue a page break first if needed
                $this->CheckPageBreak($h);
                //Draw the cells of the row
                for ($i = 0; $i < count($data); $i++) {
                    $w = $this->widths[$i];
                    $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
                    //Save the current position
                    $x = $this->GetX();
                    $y = $this->GetY();
                    //Draw the border
                    $this->Rect($x, $y, $w, $h);
                    //Print the text
                    $this->MultiCell($w, 5, $data[$i], 0, $a);
                    //Put the position to the right of the cell
                    $this->SetXY($x + $w, $y);
                }
                //Go to the next line
                $this->Ln($h);
            }

            function CheckPageBreak($h)
            {
                //If the height h would cause an overflow, add a new page immediately
                if ($this->GetY() + $h > $this->PageBreakTrigger)
                    $this->AddPage($this->CurOrientation);
            }

            function NbLines($w, $txt)
            {
                //Computes the number of lines a MultiCell of width w will take
                $cw = &$this->CurrentFont['cw'];
                if ($w == 0)
                    $w = $this->w - $this->rMargin - $this->x;
                $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
                $s = str_replace("\r", '', $txt);
                $nb = strlen($s);
                if ($nb > 0 and $s[$nb - 1] == "\n")
                    $nb--;
                $sep = -1;
                $i = 0;
                $j = 0;
                $l = 0;
                $nl = 1;
                while ($i < $nb) {
                    $c = $s[$i];
                    if ($c == "\n") {
                        $i++;
                        $sep = -1;
                        $j = $i;
                        $l = 0;
                        $nl++;
                        continue;
                    }
                    if ($c == ' ')
                        $sep = $i;
                    $l += $cw[$c];
                    if ($l > $wmax) {
                        if ($sep == -1) {
                            if ($i == $j)
                                $i++;
                        } else
                            $i = $sep + 1;
                        $sep = -1;
                        $j = $i;
                        $l = 0;
                        $nl++;
                    } else
                        $i++;
                }
                return $nl;
            }
        };

        // Generar el contenido del PDF
        $pdf->AddPage('L');
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->Ln(5);

        // Título de la tabla
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetTextColor(26, 137, 164);
        $pdf->Cell(0, 8, utf8_decode('LISTADO DE INCIDENCIAS'), 0, 1, 'C');
        $pdf->Ln(2);

        // Encabezados de la tabla
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->setFillColor(26, 137, 164);
        
        // Definir anchos de columnas
        $w = array(25, 25, 77, 20, 70, 30, 20);
        
        // Encabezados
        $pdf->Cell($w[0], 7, utf8_decode('EMPRESA'), 1, 0, 'C', 1);
        $pdf->Cell($w[1], 7, utf8_decode('RUC'), 1, 0, 'C', 1);
        $pdf->Cell($w[2], 7, utf8_decode('CLIENTE'), 1, 0, 'C', 1);
        $pdf->Cell($w[5], 7, utf8_decode('DOCUMENTO'), 1, 0, 'C', 1);
        $pdf->Cell($w[4], 7, utf8_decode('RECLAMO'), 1, 0, 'C', 1);
        $pdf->Cell($w[5], 7, utf8_decode('FECHA RECLAMO'), 1, 0, 'C', 1);
        $pdf->Cell($w[6], 7, utf8_decode('ESTADO'), 1, 1, 'C', 1);
        
        // Datos de la tabla
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(0, 0, 0);
        
        // Contador para alternar colores
        $count = 0;
        
        foreach ($articulos as $articulo) {
            // Calcular altura necesaria para el cliente y el reclamo
            $interlineado = 5; // Ajustamos el interlineado a un punto medio
            $nb_cliente = $pdf->NbLines($w[2], utf8_decode($articulo['nombre']));
            $nb_reclamo = $pdf->NbLines($w[4], utf8_decode($articulo['reclamo']));
            $altura_fila = max($nb_cliente, $nb_reclamo) * $interlineado;
            $altura_fila = max($altura_fila, $interlineado); // Asegurar altura mínima
            
            // Alternar colores de filas
            if ($count % 2 == 0) {
                $pdf->setFillColor(245, 245, 245);
            } else {
                $pdf->setFillColor(255, 255, 255);
            }
            
            // Formatear la fecha para mejor visualización
            $fecha = date('d/m/Y', strtotime($articulo['fecha_reclamo']));
            
            // Determinar color del estado
            $estadoColor = array(0, 0, 0); // Negro por defecto
            if (strtoupper($articulo['estado']) == 'PENDIENTE') {
                $estadoColor = array(255, 0, 0); // Rojo
            } elseif (strtoupper($articulo['estado']) == 'ATENDIDO') {
                $estadoColor = array(0, 128, 0); // Verde
            } elseif (strtoupper($articulo['estado']) == 'CERRADO') {
                $estadoColor = array(0, 0, 255); // Azul
            }
            
            // Dibujar celdas con la altura calculada
            $pdf->Cell($w[0], $altura_fila, utf8_decode($articulo['empresa']), 1, 0, 'C', $count % 2 == 0);
            $pdf->Cell($w[1], $altura_fila, utf8_decode($articulo['ruc']), 1, 0, 'C', $count % 2 == 0);
            
            // Guardar la posición actual para la columna cliente
            $x_cliente = $pdf->GetX();
            $y_cliente = $pdf->GetY();
            
            // Dibujar el borde de la celda del cliente
            $pdf->Rect($x_cliente, $y_cliente, $w[2], $altura_fila);
            
            // Usar MultiCell para el nombre del cliente con interlineado reducido
            $pdf->MultiCell($w[2], $interlineado, utf8_decode($articulo['nombre']), 0, 'L');
            
            // Restaurar la posición para continuar
            $pdf->SetXY($x_cliente + $w[2], $y_cliente);
            
            $pdf->Cell($w[5], $altura_fila, utf8_decode($articulo['documento']), 1, 0, 'C', $count % 2 == 0);
            
            // Guardar la posición actual para el reclamo
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            
            // Dibujar el borde de la celda del reclamo
            $pdf->Rect($x, $y, $w[4], $altura_fila);
            
            // Usar MultiCell para la descripción del reclamo con interlineado reducido
            $pdf->MultiCell($w[4], $interlineado, utf8_decode($articulo['reclamo']), 0, 'L');
            
            // Restaurar la posición para continuar con las siguientes celdas
            $pdf->SetXY($x + $w[4], $y);
            
            $pdf->Cell($w[5], $altura_fila, $fecha, 1, 0, 'C', $count % 2 == 0);
            
            // Estado con color
            $pdf->SetTextColor($estadoColor[0], $estadoColor[1], $estadoColor[2]);
            $pdf->Cell($w[6], $altura_fila, utf8_decode($articulo['estado']), 1, 1, 'C', $count % 2 == 0);
            $pdf->SetTextColor(0, 0, 0);
            
            $count++;
        }
        
        // Resumen al final
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(26, 137, 164);
        $pdf->Cell(0, 8, utf8_decode('RESUMEN DE INCIDENCIAS'), 0, 1, 'C');
        
        // Contar estados
        $pendientes = 0;
        $atendidos = 0;
        $cerrados = 0;
        
        foreach ($articulos as $articulo) {
            if (strtoupper($articulo['estado']) == 'PENDIENTE') {
                $pendientes++;
            } elseif (strtoupper($articulo['estado']) == 'ATENDIDO') {
                $atendidos++;
            } elseif (strtoupper($articulo['estado']) == 'CERRADO') {
                $cerrados++;
            }
        }
        
        // Tabla de resumen
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->setFillColor(245, 245, 245);
        
        $pdf->Cell(90, 6, utf8_decode('Total de Incidencias:'), 1, 0, 'R', 1);
        $pdf->Cell(90, 6, count($articulos), 1, 1, 'C', 1);
        
        $pdf->Cell(90, 6, utf8_decode('Pendientes:'), 1, 0, 'R', 1);
        $pdf->Cell(90, 6, $pendientes, 1, 1, 'C', 1);
        
        $pdf->Cell(90, 6, utf8_decode('Atendidos:'), 1, 0, 'R', 1);
        $pdf->Cell(90, 6, $atendidos, 1, 1, 'C', 1);
        
        $pdf->Cell(90, 6, utf8_decode('Cerrados:'), 1, 0, 'R', 1);
        $pdf->Cell(90, 6, $cerrados, 1, 1, 'C', 1);

        // Establecer los encabezados para la respuesta PDF
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="reporte_incidencias.pdf"');
        // Generar el PDF y enviarlo al navegador
        $pdf->Output('I', 'reporte_incidencias.pdf');
        exit; // Termina el script para evitar contenido adicional en la respuesta
    }

    public function rptindividual()
    {
        require_once(APPPATH . 'Libraries/fpdf/fpdf.php');

        // Obtener el parámetro
        $cod = $this->request->getPost('cod');
        $nombreusuario = session()->get('nombreusuariocorto');
        $nombresucursal = session()->get('nombresucursal');
        $nombrealmacen = session()->get('nombrealmacen');

        $model = new IncideConsulModel();
        $incidencia = $model->traer_incidencias_x_cod($cod);

        // Crear el objeto PDF
        $pdf = new class($nombreusuario, $nombresucursal, $nombrealmacen) extends \FPDF {
            private $nombreusuario;
            private $nombresucursal;
            private $nombrealmacen;

            public function __construct($nombreusuario, $nombresucursal, $nombrealmacen)
            {
                parent::__construct();
                $this->nombreusuario = $nombreusuario;
                $this->nombresucursal = $nombresucursal;
                $this->nombrealmacen = $nombrealmacen;
            }

            // Encabezado
            function Header()
            {
                $this->SetFont('Arial', '', 8);
                $this->Cell(0, 4, 'Fecha: ' . date("d/m/Y"), 0, 1, 'R');
                $this->Cell(0, 4, 'Usuario: ' . $this->nombreusuario, 0, 1, 'R');

                $this->SetFont('Arial', 'B', 12);
                $this->Cell(0, 10, 'REPORTE DE INCIDENCIA INDIVIDUAL', 0, 1, 'C');
                $this->SetFont('Arial', '', 9);
                $this->Cell(0, 5, 'SUCURSAL: ' . $this->nombresucursal . '    ALMACEN: ' . $this->nombrealmacen, 0, 1, 'L');
                $this->Ln(5);
            }

            // Pie de página
            function Footer()
            {
                $this->SetY(-15);
                $this->SetFont('Arial', 'I', 8);
                $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
            }
        };

        // Generar el contenido del PDF
        $pdf->AddPage();
        $pdf->AliasNbPages();

        // Estilos
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 10, 'ID de Incidencia:', 0, 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, $incidencia['idreclamos'], 0, 1);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 10, 'ID Cliente:', 0, 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, $incidencia['idclientes'], 0, 1);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 10, 'Fecha Reclamo:', 0, 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, $incidencia['fecha_reclamo'], 0, 1);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 10, 'Estado:', 0, 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, $incidencia['estado'], 0, 1);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 10, 'Descripcion:', 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(0, 10, utf8_decode($incidencia['descripcion']), 0, 'L');

        // Salida del PDF
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="reporte_incidencia_'.$cod.'.pdf"');
        $pdf->Output('I', 'reporte_incidencia_'.$cod.'.pdf');
        exit;
    }

    public function busc_clientes()
    {
        try {
            $termino = $this->request->getGet('q');
            $pagina = $this->request->getGet('page') ?? 1;
            $limite = 10;
            $offset = ($pagina - 1) * $limite;

            if (strlen($termino) >= 1) {
                $model = new ClientesModel();
                $clientes = $model->get_activos_dt($termino, $limite, $offset);

                $total = $model->where('estado', 'ACTIVO')
                    ->like('nombre', $termino)
                    ->countAllResults();

                return $this->response->setJSON([
                    'clientes' => $clientes,
                    'total' => $total,
                    'pagina' => (int)$pagina,
                    'limite' => $limite
                ]);
            }

            return $this->response->setJSON([
                'clientes' => [],
                'total' => 0,
                'pagina' => (int)$pagina,
                'limite' => $limite
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'error' => true,
                    'message' => 'Error en la búsqueda: ' . $e->getMessage()
                ]);
        }
    }
}