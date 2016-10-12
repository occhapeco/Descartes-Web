<?php
	//define('FPDF_FONTPATH', 'font/');
	require_once('fpdf181/fpdf.php');
	require_once("../conectar_service.php");
        if(!isset($_SESSION))
                session_start();

	$pdf = new FPDF ('P','cm','A4');
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','','12');

	if (isset($_POST["aceito"]))
        {
                $json_dados = $service->call('agendamento.select_aceitos_by_empresa',array($_SESSION["id"]));
                $aceito = json_decode($json_dados);
                for($i=0; $i<count($aceito);$i++)
                {
                	$pdf->Cell(5,2,$aceito->data_agendamento,0,0);
                	$pdf->Cell(5,2,$aceito->horario,0,0);
                	$json_dados = $service->call('endereco.select_by_id',array($aceito[$i]->usuario_id));
                	$endereco = json_decode($json_dados);
                	$end = $endereco[0]->cidade;
                	$end += ', ';
                	$end += $endereco[0]->bairro;
                	$end += ', ';
                	$end += $endereco[0]->rua;
                	$end +=', ';
                	$end += $endereco[0]->num;
                	$end +=', ';
                	$end += $endereco[0]->complemento;
                	$end += ', ';
                	$end += $endereco[0]->cep;
                	$pdf->Cell(5,2,$end,1,1);
                }
        		$pdf->OutPut();
	}
	
	if (isset($_POST["realizado"]))
        {
                $json_dados = $service->call('agendamento.select_realizados_by_empresa',array($_SESSION["id"]));
                $realizado = json_decode($json_dados);
                for($i=0; $i<count($realizado);$i++)
                {
                	$pdf->Cell(5,2,$realizado->data_agendamento,0,0);
                	$pdf->Cell(5,2,$realizado->horario,0,0);
                	$json_dados = $service->call('endereco.select_by_id',array($realizado->usuario_id));
                	$endereco = json_decode($json_dados);
                	$end = $endereco[0]->cidade;
                	$end += ', ';
                	$end += $endereco[0]->bairro;
                	$end += ', ';
                	$end += $endereco[0]->rua;
                	$end +=', ';
                	$end += $endereco[0]->num;
                	$end +=', ';
                	$end += $endereco[0]->complemento;
                	$end += ', ';
                	$end += $endereco[0]->cep;
                	$pdf->Cell(5,2,$end,1,1);
                }
        		$pdf->OutPut();
	}
	
	if (isset($_POST["atrasado"]))
        {
                $json_dados = $service->call('agendamento.select_atrasados_by_empresa',array($_SESSION["id"]));
                $atrasado = json_decode($json_dados);
                for($i=0; $i<count($atrasado);$i++)
                {
                	$pdf->Cell(5,2,$atrasado->data_agendamento,0,0);
                	$pdf->Cell(5,2,$atrasado->horario,0,0);
                	$json_dados = $service->call('endereco.select_by_id',array($atrasado->usuario_id));
                	$endereco = json_decode($json_dados);
                	$end = $endereco[0]->cidade;
                	$end += ', ';
                	$end += $endereco[0]->bairro;
                	$end += ', ';
                	$end += $endereco[0]->rua;
                	$end +=', ';
                	$end += $endereco[0]->num;
                	$end +=', ';
                	$end += $endereco[0]->complemento;
                	$end += ', ';
                	$end += $endereco[0]->cep;
                	$pdf->Cell(5,2,$end,1,1);
                }
        		$pdf->OutPut();
	}

        if (isset($_POST["em_espera"]))
        {
                $json_dados = $service->call('agendamento.select_atrasados_by_empresa',array($_SESSION["id"]));
                $atrasado = json_decode($json_dados);
                for($i=0; $i<count($atrasado);$i++)
                {
                        $pdf->Cell(5,2,$atrasado->data_agendamento,0,0);
                        $pdf->Cell(5,2,$atrasado->horario,0,0);
                        $json_dados = $service->call('endereco.select_by_id',array($atrasado->usuario_id));
                        $endereco = json_decode($json_dados);
                        $end = $endereco[0]->cidade;
                        $end += ', ';
                        $end += $endereco[0]->bairro;
                        $end += ', ';
                        $end += $endereco[0]->rua;
                        $end +=', ';
                        $end += $endereco[0]->num;
                        $end +=', ';
                        $end += $endereco[0]->complemento;
                        $end += ', ';
                        $end += $endereco[0]->cep;
                        $pdf->Cell(5,2,$end,1,1);
                }
                $pdf->OutPut();
        }


	

?>