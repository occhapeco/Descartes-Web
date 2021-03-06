<?php
	//define('FPDF_FONTPATH', 'font/');
	require_once('fpdf181/fpdf.php');
	require_once("../conectar_service.php");
        if(!isset($_SESSION))
                session_start();

	$pdf = new FPDF ('L','cm','A4');
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','','12');

	if (isset($_POST["aceito"]))
        {
                $json_dados = $service->call('agendamento.select_aceitos_by_empresa',array($_SESSION["id"]));
                $aceito = json_decode($json_dados);
                $pdf->SetFont('Arial','b','12');
                $pdf->Cell(4,1,"Date",1,0);
                $pdf->Cell(3,1,utf8_decode("Temps"),1,0);
                $pdf->cell(4,1,"Demandeur",1,0);
                $pdf->cell(3,1,"Téléphone",1,0);
                $pdf->cell(13,1,utf8_decode("Adresse"),1,1);
                $pdf->SetFont('Arial','','12');
                for($i=0; $i<count($aceito);$i++)
                {
                        $data_agendamento = DateTime::createFromFormat('Y-m-d',$aceito[$i]->data_agendamento);
                        $format = $data_agendamento->format('d/m/Y');

                        $pdf->Cell(4,1,$format,1,0);
                	$pdf->Cell(4,1,$aceito[$i]->data_agendamento,1,0);
                	$pdf->Cell(3,1,$aceito[$i]->horario,1,0);
                        $json_dados = $service->call('usuario.select', array('id = ' .$aceito[$i]->usuario_id));
                        $usuario = json_decode($json_dados);
                        $pdf->Cell(4,1,utf8_decode($usuario[0]->nome),1,0);
                        $pdf->Cell(3,1,$usuario[0]->telefone,1,0);
                	$json_dados = $service->call('endereco.select_by_id',array($aceito[$i]->endereco_id));
                	$endereco = json_decode($json_dados);
                	$end = $endereco[0]->rua;
                        $end .=', ';
                        $end .= $endereco[0]->num;
                        $end .=', ';
                        $end .= $endereco[0]->complemento;
                        $end .= ', ';
                        $end .= $endereco[0]->cep;
                        $end .= ', ';
                        $end .= $endereco[0]->cidade;
                        $end .= ', ';
                        $end .= $endereco[0]->bairro;
                        $end = utf8_decode($end);
                        $pdf->Cell(13,1,$end,1,1);
                }
        		$pdf->OutPut();
	}
	
	if (isset($_POST["realizado"]))
        {
                $json_dados = $service->call('agendamento.select_realizados_by_empresa',array($_SESSION["id"]));
                $realizado = json_decode($json_dados);
                $pdf->SetFont('Arial','b','12');
                $pdf->Cell(4,1,"Date",1,0);
                $pdf->Cell(3,1,utf8_decode("Temps"),1,0);
                $pdf->cell(4,1,"Demandeur",1,0);
                $pdf->cell(3,1,utf8_decode("Téléphone"),1,0);
                $pdf->cell(13,1,utf8_decode("Adresse"),1,1);
                $pdf->SetFont('Arial','','12');
                for($i=0; $i<count($realizado);$i++)
                {
                        $data_agendamento = DateTime::createFromFormat('Y-m-d',$realizado[$i]->data_agendamento);
                        $format = $data_agendamento->format('d/m/Y');

                        $pdf->Cell(4,1,$format,1,0);
                	$pdf->Cell(4,1,$realizado[$i]->data_agendamento,1,0);
                	$pdf->Cell(3,1,$realizado[$i]->horario,1,0);
                        $json_dados = $service->call('usuario.select', array('id = ' .$realizado[$i]->usuario_id));
                        $usuario = json_decode($json_dados);
                        $pdf->Cell(4,1,utf8_decode($usuario[0]->nome),1,0);
                        $pdf->Cell(3,1,$usuario[0]->telefone,1,0);
                	$json_dados = $service->call('endereco.select_by_id',array($realizado[$i]->endereco_id));
                	$endereco = json_decode($json_dados);
                	$end = $endereco[0]->rua;
                        $end .=', ';
                        $end .= $endereco[0]->num;
                        $end .=', ';
                        $end .= $endereco[0]->complemento;
                        $end .= ', ';
                        $end .= $endereco[0]->cep;
                        $end .= ', ';
                        $end .= $endereco[0]->cidade;
                        $end .= ', ';
                        $end .= $endereco[0]->bairro;
                        $end = utf8_decode($end);
                        $pdf->Cell(13,1,$end,1,1);
                }
        		$pdf->OutPut();
	}
	
	if (isset($_POST["atrasado"]))
        {
                $json_dados = $service->call('agendamento.select_atrasados_by_empresa',array($_SESSION["id"]));
                $atrasado = json_decode($json_dados);
                $pdf->SetFont('Arial','b','12');
                $pdf->Cell(4,1,"Date",1,0);
                $pdf->Cell(3,1,utf8_decode("Temps"),1,0);
                $pdf->cell(4,1,"Demandeur",1,0);
                $pdf->cell(3,1,"Téléphone",1,0);
                $pdf->cell(13,1,utf8_decode("Adresse"),1,1);
                $pdf->SetFont('Arial','','12');
                for($i=0; $i<count($atrasado);$i++)
                {
                        $data_agendamento = DateTime::createFromFormat('Y-m-d',$atrasado[$i]->data_agendamento);
                        $format = $data_agendamento->format('d/m/Y');

                        $pdf->Cell(4,1,$format,1,0);
                	$pdf->Cell(4,1,$atrasado[$i]->data_agendamento,1,0);
                	$pdf->Cell(3,1,$atrasado[$i]->horario,1,0);
                        $json_dados = $service->call('usuario.select', array('id = ' .$atrasado[$i]->usuario_id));
                        $usuario = json_decode($json_dados);
                        $pdf->Cell(4,1,utf8_decode($usuario[0]->nome),1,0);
                        $pdf->Cell(3,1,$usuario[0]->telefone,1,0);
                	$json_dados = $service->call('endereco.select_by_id',array($atrasado[$i]->endereco_id));
                	$endereco = json_decode($json_dados);
                	$end = $endereco[0]->rua;
                	$end .=', ';
                	$end .= $endereco[0]->num;
                	$end .=', ';
                	$end .= $endereco[0]->complemento;
                	$end .= ', ';
                        $end .= $endereco[0]->cep;
                        $end .= ', ';
                        $end .= $endereco[0]->cidade;
                        $end .= ', ';
                        $end .= $endereco[0]->bairro;
                        $end = utf8_decode($end);
                	$pdf->Cell(13,1,$end,1,1);
                }
        		$pdf->OutPut();
	}

        if (isset($_POST["em_espera"]))
        {
                $json_dados = $service->call('agendamento.select_sem_resposta_by_empresa',array($_SESSION["id"]));
                $em_espera = json_decode($json_dados);
                $pdf->SetFont('Arial','b','12');
                $pdf->Cell(4,1,"Date",1,0);
                $pdf->Cell(3,1,utf8_decode("Temps"),1,0);
                $pdf->cell(4,1,"Demandeur",1,0);
                $pdf->cell(3,1,"Téléphone",1,0);
                $pdf->cell(13,1,utf8_decode("Adresse"),1,1);
                $pdf->SetFont('Arial','','12');
                for($i=0; $i<count($em_espera);$i++)
                {
                        $data_agendamento = DateTime::createFromFormat('Y-m-d',$em_espera[$i]->data_agendamento);
                        $format = $data_agendamento->format('d/m/Y');

                        $pdf->Cell(4,1,$format,1,0);
                        $pdf->Cell(4,1,$em_espera[$i]->data_agendamento,1,0);
                        $pdf->Cell(3,1,$em_espera[$i]->horario,1,0);
                        $json_dados = $service->call('usuario.select', array('id = ' .$em_espera[$i]->usuario_id));
                        $usuario = json_decode($json_dados);
                        $pdf->Cell(4,1,utf8_decode($usuario[0]->nome),1,0);
                        $pdf->Cell(3,1,$usuario[0]->telefone,1,0);
                        $json_dados = $service->call('endereco.select_by_id',array($em_espera[$i]->endereco_id));
                        $endereco = json_decode($json_dados);
                        $end = $endereco[0]->rua;
                        $end .=', ';
                        $end .= $endereco[0]->num;
                        $end .=', ';
                        $end .= $endereco[0]->complemento;
                        $end .= ', ';
                        $end .= $endereco[0]->cep;
                        $end .= ', ';
                        $end .= $endereco[0]->cidade;
                        $end .= ', ';
                        $end .= $endereco[0]->bairro;
                        $end = utf8_decode($end);
                        $pdf->Cell(13,1,$end,1,1);
                }
                $pdf->OutPut();
        }

        if (isset($_POST["cancelado"]))
        {
                $json_dados = $service->call('agendamento.select_cancelados_by_empresa',array($_SESSION["id"]));
                $cancelados = json_decode($json_dados);
                $pdf->SetFont('Arial','b','12');
                $pdf->Cell(4,1,"Date",1,0);
                $pdf->Cell(3,1,utf8_decode("Temps"),1,0);
                $pdf->cell(4,1,"Demandeur",1,0);
                $pdf->cell(3,1,"Téléphone",1,0);
                $pdf->cell(13,1,utf8_decode("Adresse"),1,1);
                $pdf->SetFont('Arial','','12');
                for($i=0; $i<count($cancelados);$i++)
                {
                        $data_agendamento = DateTime::createFromFormat('Y-m-d',$cancelados[$i]->data_agendamento);
                        $format = $data_agendamento->format('d/m/Y');

                        $pdf->Cell(4,1,$format,1,0);
                        $pdf->Cell(4,1,$cancelados[$i]->data_agendamento,1,0);
                        $pdf->Cell(3,1,$cancelados[$i]->horario,1,0);
                        $json_dados = $service->call('usuario.select', array('id = ' .$cancelados[$i]->usuario_id));
                        $usuario = json_decode($json_dados);
                        $pdf->Cell(4,1,utf8_decode($usuario[0]->nome),1,0);
                        $pdf->Cell(3,1,$usuario[0]->telefone,1,0);
                        $json_dados = $service->call('endereco.select_by_id',array($cancelados[$i]->endereco_id));
                        $endereco = json_decode($json_dados);
                        $end = $endereco[0]->rua;
                        $end .=', ';
                        $end .= $endereco[0]->num;
                        $end .=', ';
                        $end .= $endereco[0]->complemento;
                        $end .= ', ';
                        $end .= $endereco[0]->cep;
                        $end .= ', ';
                        $end .= $endereco[0]->cidade;
                        $end .= ', ';
                        $end .= $endereco[0]->bairro;
                        $end = utf8_decode($end);
                        $pdf->Cell(13,1,$end,1,1);
                }
                $pdf->OutPut();
        }

	

?>