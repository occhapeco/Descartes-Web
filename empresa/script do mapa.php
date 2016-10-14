<?php
            for ($i=0;$i<$num;$i++)
            {
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
                  $json_dados = $service->call('tipo_lixo.select_by_id',array($tipo_lixo_has_ponto[$j]->tipo_lixo_id));
                  $tipo_lixo = json_decode($json_dados);
                  if ($j != 0)
                    $tipos_lixo += ", ";
                  $tipos_lixo += $tipo_lixo[0]->nome;
                }
                if ($i != 0)
                  echo ",";
              ?>
              {
                position: new google.maps.LatLng(<?php echo $endereco[0]->latitude . "," . $endereco[0]->longitude; ?>), 
                type: 'mark1',
                info:'<div id="content">'+
                      '<div id="siteNotice">'+
                      '</div>'+
                      '<h1 id="firstHeading" class="firstHeading"><?php echo $tipos_lixo; ?></h1>'+
                      '<div id="bodyContent" class="col-sm-12">'+
                      '<p name="nome" class="col-sm-6"> <?php echo $endereco[0]->rua . ', ' . $endereco[0]->num . ' ' . $endereco[0]->complemento . ', ' . $endereco[0]->bairro . ', ' . $endereco[0]->cidade . ' - ' . $endereco[0]->uf . ', ' . $endereco[0]->pais; ?></p>'+
                      '<p name="descricao" class="col-sm-6"> <?php echo $ponto[$i]->observacao; ?> </p>'+
                      '<form action="#" method="post">'+
                      '</form>'+
                      '</div>'+
                      '</div>',
                draggable:false
              }
              <?php
                }
              ?>