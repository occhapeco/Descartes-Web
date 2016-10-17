<?php
require_once("../conectar_service.php");
session_start();
            $pontos = "";
            $json_dados = $service->call('ponto.select_by_empresa',array($_SESSION["id"]));
            $ponto = json_decode($json_dados);
            $num = count($ponto);
            for ($i=0;$i<$num;$i++)
            {
              echo " i = ".$i;
              $json_dados = $service->call('endereco.select_by_id',array($ponto[$i]->endereco_id));
              $endereco = json_decode($json_dados);
              $json_dados = $service->call('tipo_lixo_has_ponto.select_by_ponto',array($ponto[$i]->id));
              $tipo_lixo_has_ponto = json_decode($json_dados);
              $tipos_lixo = "";
              if (count($tipo_lixo_has_ponto) == 0)
                $tipos_lixo += "Sem tipos de lixo!";
              else
                for ($j=0;$j<count($tipo_lixo_has_ponto);$j++)
                {
              echo " j = ".$j;

                  $json_dados = $service->call('tipo_lixo.select_by_id',array($tipo_lixo_has_ponto[$j]->tipo_lixo_id));
                  $tipo_lixo = json_decode($json_dados);
                  if ($j != 0)
                    $tipos_lixo += ", ";
                  $tipos_lixo += $tipo_lixo[0]->nome;
                }
              if ($i != 0)
                $pontos .= ",";
              $pontos .=  `{
                              position: new google.maps.LatLng(`.$endereco[0]->latitude.`,`.$endereco[0]->longitude.`), 
                              type: 'mark1',
                              info:'<div id="content">'+
                                    '<div id="siteNotice">'+
                                    '</div>'+
                                    '<h1 id="firstHeading" class="firstHeading">`.$tipos_lixo.`</h1>
                                    '<div id="bodyContent" class="col-sm-12">'+
                                    '<p name="nome" class="col-sm-6">`.$endereco[0]->rua.`, `.$endereco[0]->num.` `.$endereco[0]->complemento.`, `.$endereco[0]->bairro.`, `.$endereco[0]->cidade.` - `.$endereco[0]->uf.`, `.$endereco[0]->pais.`</p>'+
                                    '<p name="descricao" class="col-sm-6">`.$ponto[$i]->observacao.`</p>'+
                                    '<form action="#" method="post">'+
                                    '</form>'+
                                    '</div>'+
                                    '</div>',
                              draggable:false
                            }`;
            }
            echo "oisaoijs";
          ?>