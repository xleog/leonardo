<?php
namespace App\Controllers;
use App\Models\RespondIncideModel;
use CodeIgniter\Controller;

class RespondIncideController extends Controller
{
    public function index()
    {
        return view('Views/Hijos/respond_incide.php');
    }

    public function traer_respuestas()
    {
        $model = new RespondIncideModel();
        $data = $model->traer_respuestas();
        return $this->response->setJSON(['data' => $data]);  
    }

    public function get_datos_x_cod()
    {
        $model = new RespondIncideModel();
        $cod = $this->request->getGet('cod');
        $data = $model->traer_respuesta_x_cod($cod);
        return $this->response->setJSON([$data]);
    }

    public function insertar()
    {
        $model = new RespondIncideModel();
        
        $data = [
            'idreclamos' => $this->request->getPost('idreclamos'),
            'idpersonal' => $this->request->getPost('idpersonal'),
            'idempresa' => $this->request->getPost('idempresa'),
            'respuesta' => $this->request->getPost('respuesta'),
            'fecha_respuesta' => $this->request->getPost('fecha_respuesta'),
            'estado' => $this->request->getPost('estado')
        ];

        try {
            $model->insert($data);
            return $this->response->setJSON(['success' => true, 'message' => 'Respuesta registrada correctamente']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error al registrar la respuesta: ' . $e->getMessage()]);
        }
    }

    public function update()
    {
        $model = new RespondIncideModel();
        $id = $this->request->getPost('cod');
        
        $data = [
            'idreclamos' => $this->request->getPost('idreclamos'),
            'idpersonal' => $this->request->getPost('idpersonal'),
            'idempresa' => $this->request->getPost('idempresa'),
            'respuesta' => $this->request->getPost('respuesta'),
            'fecha_respuesta' => $this->request->getPost('fecha_respuesta'),
            'estado' => $this->request->getPost('estado')
        ];

        try {
            if ($model->update($id, $data)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Respuesta actualizada correctamente']);
            } else {
                return $this->response->setJSON(['error' => 'No se encontró la respuesta']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error al actualizar la respuesta: ' . $e->getMessage()]);
        }
    }

    public function rptgeneral()
    {
        require_once(APPPATH . 'Libraries/fpdf/fpdf.php');

        $inicio = $this->request->getPost('i');
        $fin = $this->request->getPost('f');
        $nombreusuario = session()->get('nombreusuariocorto');
        $nombresucursal = session()->get('nombresucursal');
        $nombrealmacen = session()->get('nombrealmacen');
        $codempresa = session()->get('codempresa');

        $KardexModel = new RespondIncideModel();
        $articulos = $KardexModel->ver_articulos_fecha($inicio, $fin, $codempresa);

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

            function Header()
            {
                $this->SetFont('Arial', '', 8);
                $this->Cell(0, 4, 'Fecha: ' . date("d/m/Y"), 0, 1, 'R');
                $this->Cell(0, 4, 'Usuario: ' . $this->nombreusuario, 0, 1, 'R');

                $this->SetFont('Arial', 'B', 9);
                $this->Cell(0, 4, 'REPORTE DE INCIDENCIAS DEL: ' . $this->inicio . ' AL: ' . $this->fin, 0, 1, 'C');
                $this->Cell(0, 4, 'SUCURSAL:' . $this->nombresucursal . '    ALMACEN:' . $this->nombrealmacen, 0, 1, 'L', 0, '', 0);
                $this->SetFont('Arial', '', 7);
                $this->Ln(2);
                $this->Line(10, $this->GetY(), 285, $this->GetY());
            }

            function Footer()
            {
                $this->SetY(-15);
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(0, 8, $this->PageNo() . '/{nb}', 0, 0, 'R');
            }
            var $widths;
            var $aligns;

            function SetWidths($w) { $this->widths = $w; }
            function SetAligns($a) { $this->aligns = $a; }
            function Row($data)
            {
                $nb = 0;
                for ($i = 0; $i < count($data); $i++)
                    $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
                $h = 3 * $nb;
                $this->CheckPageBreak($h);
                for ($i = 0; $i < count($data); $i++) {
                    $w = $this->widths[$i];
                    $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
                    $x = $this->GetX();
                    $y = $this->GetY();
                    $this->Rect($x, $y, $w, $h);
                    $this->MultiCell($w, 3, $data[$i], 0, $a);
                    $this->SetXY($x + $w, $y);
                }
                $this->Ln($h);
            }

            function CheckPageBreak($h)
            {
                if ($this->GetY() + $h > $this->PageBreakTrigger)
                    $this->AddPage($this->CurOrientation);
            }

            function NbLines($w, $txt)
            {
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

        $pdf->AddPage('L');
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->Ln();

        $pdf->SetFont('Arial','B',7);
        $pdf->setFillColor(26, 137, 164);
        $pdf->Cell(70, 5, 'RECLAMO',1, 0, 'C',1);
        $pdf->Cell(50, 5, 'ENCARGADO RESPUESTA',1, 0, 'C',1);
        $pdf->Cell(40, 5, 'EMPRESA',1, 0, 'C',1);
        $pdf->Cell(60, 5, 'RESPUESTA',1, 0, 'C',1);
        $pdf->Cell(30, 5, 'FECHA DE RESPUESTA',1, 0, 'C',1);
        $pdf->Cell(15, 5, 'ESTADO',1, 1, 'C',1);

        foreach ($articulos as $articulo) {
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(70, 5, utf8_decode($articulo['RECLAMO']),1, 0, 'C',0);
            $pdf->Cell(50, 5, $articulo['ENCARGADO'],1, 0, 'C',0);
            $pdf->Cell(40, 5, $articulo['EMPRESAS'],1, 0, 'C',0);
            $pdf->Cell(60, 5, $articulo['RESPUESTA'],1, 0, 'C',0);
            $pdf->Cell(30, 5, $articulo['FECHA_RESPUESTA'],1, 0, 'C',0);
            $pdf->Cell(15, 5, $articulo['ESTADO'],1, 1, 'C',0);
        }

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="reporte.pdf"');
        $pdf->Output('I', 'reporte.pdf');
        exit;
    }
}