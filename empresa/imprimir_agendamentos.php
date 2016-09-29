<?php

        if(isset($_POST))
        {
                require_once('fpdf181/fpdf.php');
                require_once("../conectar_service.php");
                if(!isset($_SESSION))
                        session_start();
                $pdf = new FPDF ('L','cm','A4');
                $pdf->AddPage();
                $pdf->SetFont('Arial','b','12');
                $pdf->Cell(4,1,utf8_decode('Solicitante'),1,0);
                $pdf->Cell(3,1,utf8_decode('Telefone'),1,0);
                $pdf->Cell(2.5,1,utf8_decode('Data'),1,0);
                $pdf->Cell(2,1,utf8_decode('Horário'),1,0);
                $pdf->Cell(16,1,utf8_decode('Endereço'),1,1);
                $pdf->SetFont('Arial','','11');
        	if (isset($_POST["aceito"]))
                {
                        $json_dados = $service->call('agendamento.select_aceitos_by_empresa',array($_SESSION["id"]));
                        $aceito = json_decode($json_dados);
                        for($i=0; $i<count($aceito);$i++)
                        {
                                $json_dados = $service->call('usuario.select',array("id = ".$aceito[$i]->usuario_id));
                                $usuario = json_decode($json_dados);
                                $pdf->Cell(4,1,$usuario[0]->nome,1,0);
                                $pdf->Cell(3,1,$usuario[0]->telefone,1,0);
                                $pdf->Cell(2.5,1,$aceito[$i]->data_agendamento,1,0);
                                $pdf->Cell(2,1,$aceito[$i]->horario,1,0);
                                $json_dados = $service->call('endereco.select_by_id',array($aceito[$i]->endereco_id));
                                $endereco = json_decode($json_dados);
                                $end = utf8_decode($endereco[0]->rua." ".$endereco[0]->num.", ".$endereco[0]->cep.", ".$endereco[0]->bairro.", ".$endereco[0]->cidade." - ".$endereco[0]->uf.", ".$endereco[0]->pais);
                                $pdf->Cell(16,1,$end,1,1);
                        }
        	}
        	elseif (isset($_POST["realizado"]))
                {
                        $json_dados = $service->call('agendamento.select_realizados_by_empresa',array($_SESSION["id"]));
                        $realizado = json_decode($json_dados);
                        for($i=0; $i<count($realizado);$i++)
                        {
                                $json_dados = $service->call('usuario.select',array("id = ".$realizado[$i]->usuario_id));
                                $usuario = json_decode($json_dados);
                                $pdf->Cell(4,1,$usuario[0]->nome,1,0);
                                $pdf->Cell(3,1,$usuario[0]->telefone,1,0);
                        	$pdf->Cell(2.5,1,$realizado[$i]->data_agendamento,1,0);
                        	$pdf->Cell(2,1,$realizado[$i]->horario,1,0);
                        	$json_dados = $service->call('endereco.select_by_id',array($realizado[$i]->endereco_id));
                        	$endereco = json_decode($json_dados);
                                $end = utf8_decode($endereco[0]->rua." ".$endereco[0]->num.", ".$endereco[0]->cep.", ".$endereco[0]->bairro.", ".$endereco[0]->cidade." - ".$endereco[0]->uf.", ".$endereco[0]->pais);
                        	$pdf->Cell(16,1,$end,1,1);
                        }
        	}
        	elseif (isset($_POST["atrasado"]))
                {
                        $json_dados = $service->call('agendamento.select_atrasados_by_empresa',array($_SESSION["id"]));
                        $atrasado = json_decode($json_dados);
                        for($i=0; $i<count($atrasado);$i++)
                        {
                                $json_dados = $service->call('usuario.select',array("id = ".$atrasado[$i]->usuario_id));
                                $usuario = json_decode($json_dados);
                                $pdf->Cell(4,1,$usuario[0]->nome,1,0);
                                $pdf->Cell(3,1,$usuario[0]->telefone,1,0);
                                $pdf->Cell(2.5,1,$atrasado[$i]->data_agendamento,1,0);
                                $pdf->Cell(2,1,$atrasado[$i]->horario,1,0);
                                $json_dados = $service->call('endereco.select_by_id',array($atrasado[$i]->endereco_id));
                                $endereco = json_decode($json_dados);
                                $end = utf8_decode($endereco[0]->rua." ".$endereco[0]->num.", ".$endereco[0]->cep.", ".$endereco[0]->bairro.", ".$endereco[0]->cidade." - ".$endereco[0]->uf.", ".$endereco[0]->pais);
                                $pdf->Cell(16,1,$end,1,1);
                        }
        	}
                elseif (isset($_POST["em_espera"]))
                {
                        $json_dados = $service->call('agendamento.select_atrasados_by_empresa',array($_SESSION["id"]));
                        $em_espera = json_decode($json_dados);
                        for($i=0; $i<count($em_espera);$i++)
                        {
                                $json_dados = $service->call('usuario.select',array("id = ".$em_espera[$i]->usuario_id));
                                $usuario = json_decode($json_dados);
                                $pdf->Cell(4,1,$usuario[0]->nome,1,0);
                                $pdf->Cell(3,1,$usuario[0]->telefone,1,0);
                                $pdf->Cell(2.5,1,$em_espera[$i]->data_agendamento,1,0);
                                $pdf->Cell(2,1,$em_espera[$i]->horario,1,0);
                                $json_dados = $service->call('endereco.select_by_id',array($em_espera[$i]->endereco_id));
                                $endereco = json_decode($json_dados);
                                $end = utf8_decode($endereco[0]->rua." ".$endereco[0]->num.", ".$endereco[0]->cep.", ".$endereco[0]->bairro.", ".$endereco[0]->cidade." - ".$endereco[0]->uf.", ".$endereco[0]->pais);
                                $pdf->Cell(16,1,$end,1,1);
                        }
                }
                $pdf->OutPut();
        }
        else
                header("location: index.php");

?>