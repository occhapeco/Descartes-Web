<?php
	//define('FPDF_FONTPATH', 'font/');
	require_once('fpdf181/fpdf.php');
	require_once("../conectar_service.php");
        if(!isset($_SESSION))
                session_start();

	$pdf = new FPDF ('P','cm','A4');
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','b','12');
        $pdf->Cell(3,0.7,"Date",1,0);
        $pdf->Cell(3,0.7,utf8_decode("Temps"),1,0);
        $pdf->Cell(4,0.7,utf8_decode("Adresse"),1,0);
        $pdf->Cell(5,0.7,"Compagnie de collecte",1,0);
        $pdf->Cell(4,0.7,"statut",1,1);
        $pdf->SetFont('Arial','','12');


        
                        $json_dados = $service->call('agendamento.select',array('usuario_id = '. $_SESSION["id"]));
                        $agendamento = json_decode($json_dados);
                        for($i=0;$i<count($agendamento);$i++)
                        {
                                $json_dados = $service->call('usuario_has_endereco.select', array('usuario_id = '.$_SESSION["id"].' AND endereco_id = '. $agendamento[$i]->endereco_id));
                                $endereco = json_decode($json_dados);
                                $json_dados = $service->call('usuario.select', array('id = '. $agendamento[$i]->usuario_id));
                                $usuario = json_decode($json_dados);
                                $status = "";

                                $data_agendamento = DateTime::createFromFormat('Y-m-d',$agendamento[$i]->data_agendamento);
                                $format = $data_agendamento->format('d/m/Y');

                                if($agendamento[$i]->aceito == 0 and $agendamento[$i]->realizado == 0)
                                {
                                  $status = 'Pas confirmé'; 
                                }
                                if($agendamento[$i]->aceito == 1 and $agendamento[$i]->realizado == 0 and $agendamento[$i]->data_agendamento <= date("Y-m-d"))
                                {
                                  $status = 'Attendre';
                                }
                                if($agendamento[$i]->aceito == 1 and $agendamento[$i]->realizado == 0 and $agendamento[$i]->data_agendamento > date("Y-m-d"))
                                {
                                  $status = 'En retard';
                                }
                                if($agendamento[$i]->aceito == 1 and $agendamento[$i]->realizado == 1)
                                {
                                  $status = 'Fini';
                                }
                                if($agendamento[$i]->aceito == 0 and $agendamento[$i]->realizado == 1)
                                {
                                  $status = 'Annulé';
                                }

                                $pdf->Cell(3,0.7,$format,1,0);
                                $pdf->Cell(3,0.7,$agendamento[$i]->horario,1,0);
                                $pdf->Cell(4,0.7,$endereco[0]->nome,1,0);
                                $json_dados = $service->call('empresa.select_by_id', array($agendamento[$i]->empresa_id));
                                $empresa = json_decode($json_dados);
                                $pdf->cell(5,0.7,$empresa[0]->nome_fantasia,1,0);
                                $pdf->cell(4,0.7,$status,1,1);
                        }
                        $pdf->OutPut();


	

?>