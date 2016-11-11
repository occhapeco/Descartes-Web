<?php
	require_once('lib/nusoap.php');

	header('Content-Type: text/html; charset=iso-8859-1');

	$server = new soap_server;
	$server->configureWSDL('service.descartes','urn:service.descartes');
	$namespace = 'urn:service.descartes';
	$server->wsdl->schemaTargetNamespace = $namespace;

	function validar_cpf($cpf){
		// Verifica se um número foi informado
	    if(empty($cpf))
	        return false;

	    // Elimina possivel mascara
	    $cpf = $cpf = preg_replace("![^0-9]+!",'',$cpf);
	    $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

	    // Verifica se o numero de digitos informados é igual a 11
	    if (strlen($cpf) != 11)
	        return false;

	    // Verifica se nenhuma das sequências invalidas abaixo
	    // foi digitada. Caso afirmativo, retorna falso
	    else if($cpf == '00000000000' ||
		        $cpf == '11111111111' ||
		        $cpf == '22222222222' ||
		        $cpf == '33333333333' ||
		        $cpf == '44444444444' ||
		        $cpf == '55555555555' ||
		        $cpf == '66666666666' ||
		        $cpf == '77777777777' ||
		        $cpf == '88888888888' ||
	        	$cpf == '99999999999')
	        return false;
	     // Calcula os digitos verificadores para verificar se o
	    else {

	        for ($t = 9; $t < 11; $t++) {

	            for ($d = 0, $c = 0; $c < $t; $c++) {
	                $d += $cpf{$c} * (($t + 1) - $c);
	            }
	            $d = ((10 * $d) % 11) % 10;
	            if ($cpf{$c} != $d) {
	                return false;
	            }
	        }

	        return true;
	    }
	}

	//-------Classes do server-------//
	class master {
		function login($email,$senha) {
			$email = preg_replace('![*#/\"´`]+!','',$email);
			$senha = sha1($senha);
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM master WHERE email = '$email' AND senha = '$senha'");
			$retorno = 0;
			if (mysqli_num_rows($query) == 1)
			{
				$row = mysqli_fetch_assoc($query);
				$retorno = $row["id"];
			}
			$conexao->close();
			return $retorno;
		}
		function select_by_id($id) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM master WHERE id = $id");
			$dados = array();
			while($row = mysqli_fetch_assoc($query))
			    $dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}
	}
	// Registro dos métodos da classe master //
	$server->register('master.login', array('email' => 'xsd:string','senha' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Realiza o login em um master (retorna id).');
	$server->register('master.select_by_id', array('id' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa um registro da tabela master por id (retorna json).');

	// Classe da tabela tipo_lixo //
	class tipo_lixo {
	    function insert($nome,$nome_eng) {
	    	$nome = preg_replace('![*#/\"´`]+!','',$nome);
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	    	$query = $conexao->query("INSERT INTO tipo_lixo VALUES(NULL,'$nome','$nome_eng')");
	    	$id = 0;
	    	if ($query == true)
	    		$id = $conexao->insert_id;
			$conexao->close();
	      	return $id;
	    }
	    function update($id,$nome,$nome_eng) {
	    	$nome = preg_replace('![*#/\"´`]+!','',$nome);
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	    	$query = $conexao->query("SELECT * FROM tipo_lixo WHERE id = $id");
	    	$retorno = false;
			if (mysqli_num_rows($query) == 1)
			{
		    	$query = $conexao->query("UPDATE tipo_lixo SET nome = '$nome',nome_eng = '$nome_eng' WHERE id = $id");
				$retorno = true;
			}
			$conexao->close();
	     	return $retorno;
	    }
	    function delete($id) {
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	    	$query = $conexao->query("DELETE FROM tipo_lixo_has_ponto WHERE tipo_lixo_id = $id");
	    	$query = $conexao->query("DELETE FROM agendamento_has_tipo_lixo WHERE tipo_lixo_id = $id");
	    	$query = $conexao->query("DELETE FROM tipo_lixo WHERE id = $id");
	    	$retorno = false;
	    	$query = $conexao->query("SELECT * FROM tipo_lixo WHERE id = $id");
	    	if (mysqli_num_rows($query) == 0)
	    		$retorno = true;
			$conexao->close();
	  		return $retorno;
	    }
	    function select_by_id($id) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM tipo_lixo WHERE id = $id");
			$dados = array();
			while($row = mysqli_fetch_assoc($query))
			    $dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}
		function select($condicoes) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			if ($condicoes != NULL)
				$condicoes = "WHERE " . $condicoes;
			$query = $conexao->query("SELECT * FROM tipo_lixo $condicoes");
			$dados = array();
			while($row = mysqli_fetch_assoc($query))
			    $dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}
	}
	// Registro dos métodos da classe tipo_lixo //
	$server->register('tipo_lixo.insert', array('nome' => 'xsd:string','nome_eng' => 'xsd:string'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Insere um registro na table tipo_lixo (retorna o id do registro inserido).');
	$server->register('tipo_lixo.update', array('id' => 'xsd:integer','nome' => 'xsd:string','nome_eng' => 'xsd:string'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Altera um registro da tabela tipo_lixo.');
	$server->register('tipo_lixo.delete', array('id' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Deleta um registro da tabela tipo_lixo.');
	$server->register('tipo_lixo.select_by_id', array('id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa registros da tabela tipo_lixo por id (retorna json).');
	$server->register('tipo_lixo.select', array('condicoes' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa registros da tabela tipo_lixo com condições definidas ou indefinidas (retorna json).');

	// Classe da tabela endereco //
	class endereco {
		function insert($rua,$num,$complemento,$cep,$bairro,$estado,$cidade,$pais,$latitude,$longitude) {
			$rua = preg_replace('![*#/\"´`]+!','',$rua);
			$complemento = preg_replace('![*#/\"´`]+!','',$complemento);
			$cep = preg_replace("![^0-9]+!",'',$cep);
			$bairro = preg_replace('![*#/\"´`]+!','',$bairro);
			$estado = preg_replace('![*#/\"´`]+!','',$estado);
			$cidade = preg_replace('![*#/\"´`]+!','',$cidade);
			$pais = preg_replace('![*#/\"´`]+!','',$pais);
			$id = 0;
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	    	$query = $conexao->query("INSERT INTO endereco VALUES(NULL,'$rua','$num','$complemento','$cep','$bairro','$estado','$cidade','$pais',$latitude,$longitude)");
	    	if ($query == true)
	    		$id = $conexao->insert_id;
			$conexao->close();
	      	return $id;
	    }
	    function update($id,$rua,$num,$complemento,$cep,$bairro,$estado,$cidade,$pais,$latitude,$longitude) {
	    	$rua = preg_replace('![*#/\"´`]+!','',$rua);
			$complemento = preg_replace('![*#/\"´`]+!','',$complemento);
			$cep = preg_replace("![^0-9]+!",'',$cep);
			$bairro = preg_replace('![*#/\"´`]+!','',$bairro);
			$estado = preg_replace('![*#/\"´`]+!','',$estado);
			$cidade = preg_replace('![*#/\"´`]+!','',$cidade);
			$pais = preg_replace('![*#/\"´`]+!','',$pais);
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	    	$query = $conexao->query("SELECT * FROM endereco WHERE id = $id");
	    	$retorno = false;
			if (mysqli_num_rows($query) == 1)
			{
		    	$query = $conexao->query("UPDATE endereco SET rua = '$rua',num = '$num',complemento = '$complemento',cep = '$cep',bairro = '$bairro',uf = '$estado',cidade = '$cidade',pais = '$pais',latitude = $latitude,longitude = $longitude WHERE id = $id");
				$query = $conexao->query("SELECT * FROM endereco WHERE id = $id");
				$row = mysqli_fetch_assoc($query);
				$retorno = true;
			}
			$conexao->close();
	     	return $retorno;
	    }
	    function delete($id) {
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	    	$query = $conexao->query("DELETE FROM ponto WHERE endereco_id = $id");
	    	$query = $conexao->query("DELETE FROM agendamento WHERE endereco_id = $id");
	    	$query = $conexao->query("DELETE FROM usuario_has_endereco WHERE endereco_id = $id");
	    	$query = $conexao->query("DELETE FROM endereco WHERE id = $id");
	    	$retorno = false;
	    	$query = $conexao->query("SELECT * FROM endereco WHERE id = $id");
	    	if (mysqli_num_rows($query) == 0)
	    		$retorno = true;
			$conexao->close();
	  		return $retorno;
	    }
	    function select_by_id($id) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM endereco WHERE id = $id");
			$dados = array();
			while($row = mysqli_fetch_assoc($query))
			    $dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}
		function select($condicoes) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			if ($condicoes != NULL)
				$condicoes = "WHERE " . $condicoes;
			$query = $conexao->query("SELECT * FROM endereco $condicoes");
			$dados = array();
			while($row = mysqli_fetch_assoc($query))
			    $dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}
	}
	// Registro dos métodos da classe endereco //
	$server->register('endereco.insert', array('rua' => 'xsd:string','num' => 'xsd:string','complemento' => 'xsd:string','cep' => 'xsd:string','cep' => 'xsd:string','bairro' => 'xsd:string','estado' => 'xsd:string','cidade' => 'xsd:string','pais' => 'xsd:string','latitude' => 'xsd:double','longitude' => 'xsd:double'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Insere um registro na table endereco (retorna o id do registro inserido).');
	$server->register('endereco.update', array('id' => 'xsd:integer','rua' => 'xsd:string','num' => 'xsd:string','complemento' => 'xsd:string','cep' => 'xsd:string','cep' => 'xsd:string','bairro' => 'xsd:string','estado' => 'xsd:string','cidade' => 'xsd:string','pais' => 'xsd:string','latitude' => 'xsd:double','longitude' => 'xsd:double'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Altera um registro da tabela endereco.');
	$server->register('endereco.delete', array('id' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Deleta um registro da tabela endereco.');
	$server->register('endereco.select_by_id', array('id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa registros da tabela endereco por id (retorna json).');
	$server->register('endereco.select', array('condicoes' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa registros da tabela endereco com condições definidas ou indefinidas (retorna json).');

	// Classe da tabela usuario //
	class usuario {
	    function insert($nome,$email,$senha,$cpf,$telefone) {
	    	$nome = preg_replace('![*#/\"´`]+!','',$nome);
			$email = preg_replace('![*#/\"´`]+!','',$email);
			$cpf = preg_replace("![^0-9]+!",'',$cpf);
			$telefone = preg_replace("![^0-9]+!",'',$telefone);
	    	if (!validar_cpf($cpf))
    			return 0;
    		$senha = sha1($senha);
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM empresa WHERE email = '$email'");
			if (mysqli_num_rows($query) == 0)
			{
				$query = $conexao->query("INSERT INTO usuario VALUES(NULL,'$nome','$email','$senha','$cpf','$telefone')");
		    	$id = 0;
		    	if ($query == true)
		    		$id = $conexao->insert_id;
			}
	    	else
	    		return 0;
			$conexao->close();
			return $id;
	    }
	    function update_perfil($id,$nome,$email,$telefone) {
	    	$nome = preg_replace('![*#/\"´`]+!','',$nome);
			$email = preg_replace('![*#/\"´`]+!','',$email);
			$telefone = preg_replace("![^0-9]+!",'',$telefone);
	      	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	    	$query = $conexao->query("SELECT * FROM usuario WHERE id = $id");
	    	$retorno = false;
			if (mysqli_num_rows($query) == 1)
			{
		    	$query = $conexao->query("UPDATE usuario SET nome = '$nome', email = '$email',telefone = '$telefone' WHERE id = $id");
				$retorno = true;
			}
			$conexao->close();
	     	return $retorno;
	    }

		function update_senha($id,$senha_antiga,$senha_nova) {
    		$senha_antiga = sha1($senha_antiga);
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	    	$retorno = false;
	    	$query = $conexao->query("SELECT * FROM usuario WHERE id = $id");
			if (mysqli_num_rows($query) == 1)
			{
				$row = $query->fetch_assoc();
				if($row["senha"] == $senha_antiga)
				{
					$senha_nova = sha1($senha_nova);
					$query = $conexao->query("UPDATE usuario SET senha = '$senha_nova' WHERE id = $id");
					$retorno = true;
				}
			}
			$conexao->close();
	      	return $retorno;
	    }

	    function delete($id) {
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	    	$query = $conexao->query("DELETE FROM usuario_has_endereco WHERE usuario_id = $id");
	    	$query = $conexao->query("SELECT * FROM agendamento WHERE usuario_id = $id");
	    	while ($row = $query->fetch_assoc())
	    	{
	    		$agendamento_id = $row["id"];
	    		$sub_query = $conexao->query("DELETE FROM agendamento_has_tipo_lixo WHERE agendamento_id = $agendamento_id");
	    		$sub_query = $conexao->query("DELETE FROM agendamento WHERE usuario_id = $id");
	    	}
	    	$query = $conexao->query("DELETE FROM usuario WHERE id = $id");
	    	$retorno = false;
	    	$query = $conexao->query("SELECT * FROM usuario WHERE id = $id");
	    	if (mysqli_num_rows($query) == 0)
	    		$retorno = true;
			$conexao->close();
	  		return $retorno;
	    }
	    function login($email,$senha) {
			$email = preg_replace('![*#/\"´`]+!','',$email);
			$senha = sha1($senha);
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'");
			$retorno = 0;
			if (mysqli_num_rows($query) == 1)
			{
				$row = mysqli_fetch_assoc($query);
				$retorno = $row["id"];
			}
			$conexao->close();
			return $retorno;
		}
		function select($condicoes) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			if ($condicoes != NULL)
				$condicoes = "WHERE " . $condicoes;
			$query = $conexao->query("SELECT * FROM usuario $condicoes");
			$dados = array();
			while($row = mysqli_fetch_assoc($query)) 
			    $dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}
	}
	// Registro dos métodos da classe usuario //
	$server->register('usuario.insert', array('nome' => 'xsd:string','email' => 'xsd:string','senha' => 'xsd:string','cpf' => 'xsd:string', 'telefone' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Insere um registro na table usuario (retorna o id do registro inserido).');
	$server->register('usuario.update_perfil', array('id' => 'xsd:integer','nome' => 'xsd:string','email' => 'xsd:string','telefone' => 'xsd:string'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Altera um registro da tabela usuario.');
	$server->register('usuario.update_senha', array('id' => 'xsd:integer','senha_antiga' => 'xsd:string','senha_nova' => 'xsd:string'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Altera a senha de um usuario testando se a senha que ele digitou é a que está registrada.');
	$server->register('usuario.delete', array('id' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Deleta um registro da tabela usuario.');
	$server->register('usuario.login', array('email' => 'xsd:string','senha' => 'xsd:string'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Pesquisa um registro da tabela usuario por email e senha (sem criptografia e retorna id).');
	$server->register('usuario.select', array('condicoes' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa registros da tabela usuario com condições definidas ou indefinidas (retorna json).');

	// Classe da tabela usuario_has_endereco //
	class usuario_has_endereco {
		function insert($usuario_id,$endereco_id,$nome) {
			$nome = preg_replace('![*#/\"´`]+!','',$nome);
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	    	$query = $conexao->query("INSERT INTO usuario_has_endereco VALUES(NULL,$usuario_id,$endereco_id,'$nome')");
	    	$id = 0;
	    	if ($query == true)
	    		$id = $conexao->insert_id;
			$conexao->close();
	      	return $id;
	    }
	    function delete($id) {
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
    		$query = $conexao->query("DELETE FROM usuario_has_endereco WHERE id = $id");
    		$retorno = false;
	    	$query = $conexao->query("SELECT * FROM usuario_has_endereco WHERE id = $id");
	    	if (mysqli_num_rows($query) == 0)
	    		$retorno = true;
			$conexao->close();
	  		return $retorno;
	    }

		function select($condicoes) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			if ($condicoes != NULL)
				$condicoes = "WHERE " . $condicoes;
			$query = $conexao->query("SELECT * FROM usuario_has_endereco $condicoes");
			$dados = array();
			while($row = mysqli_fetch_assoc($query))
			    $dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}
	}
	// Registro dos métodos da classe usuario_has_endereco //
	$server->register('usuario_has_endereco.insert', array('usuario_id' => 'xsd:integer','endereco_id' => 'xsd:integer','nome' => 'xsd:string'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Insere um registro na tabela usuario_has_endereco (retorna o id do registro inserido).');
	$server->register('usuario_has_endereco.delete', array('id' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Deleta um registro da tabela usuario_has_endereco.');
	$server->register('usuario_has_endereco.select', array('condicoes' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa registros da tabela usuario_has_endereco com condições definidas ou indefinidas (retorna json).');

	// Classe da tabela empresa //
	class empresa {
	    function insert($razao_social,$nome_fantasia,$cnpj,$senha,$email,$agendamento) {
	    	$razao_social = preg_replace('![*#/\"´`]+!','',$razao_social);
			$nome_fantasia = preg_replace('![*#/\"´`]+!','',$nome_fantasia);
			$cnpj = preg_replace("![^0-9]+!",'',$cnpj);
			$email = preg_replace('![*#/\"´`]+!','',$email);
    		$senha = sha1($senha);
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM usuario WHERE email = '$email'");
			if (mysqli_num_rows($query) == 0)
			{
				$query = $conexao->query("INSERT INTO empresa VALUES(NULL,'$razao_social','$nome_fantasia','$cnpj','$senha','$email',$agendamento)");
		    	$id = 0;
		    	if ($query == true)
		    		$id = $conexao->insert_id;
			}
	    	else
	    		return 0;
			$conexao->close();
			return $id;
	    }
	    function update_perfil($id,$razao_social,$nome_fantasia,$email,$agendamento) {
	    	$razao_social = preg_replace('![*#/\"´`]+!','',$razao_social);
			$nome_fantasia = preg_replace('![*#/\"´`]+!','',$nome_fantasia);
			$email = preg_replace('![*#/\"´`]+!','',$email);
	      	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	    	$query = $conexao->query("SELECT * FROM empresa WHERE id = $id");
	    	$retorno = false;
			if (mysqli_num_rows($query) == 1)
			{
		    	$query = $conexao->query("UPDATE empresa SET razao_social = '$razao_social',nome_fantasia = '$nome_fantasia',email = '$email',agendamento = $agendamento WHERE id = $id");
				$retorno = true;
			}
			$conexao->close();
	     	return $retorno;
	    }
		function update_senha($id,$senha_antiga,$senha_nova) {
	      	$senha_antiga = sha1($senha_antiga);
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	    	$retorno = false;
	    	$query = $conexao->query("SELECT * FROM empresa WHERE id = $id");
			if (mysqli_num_rows($query) == 1)
			{
				$row = $query->fetch_assoc();
				if($row["senha"] == $senha_antiga)
				{
					$senha_nova = sha1($senha_nova);
					$query = $conexao->query("UPDATE empresa SET senha = '$senha_nova' WHERE id = $id");
					$retorno = true;
				}
			}
			$conexao->close();
	      	return $retorno;
	    }
	    function delete($id) {
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	    	$query = $conexao->query("SELECT * FROM agendamento WHERE empresa_id = $id");
	    	while ($row = $query->fetch_assoc()){
	    		$agendamento_id = $row["id"];
	    		$sub_query = $conexao->query("DELETE FROM agendamento_has_tipo_lixo WHERE agendamento_id = $agendamento_id");
	    		$sub_query = $conexao->query("DELETE FROM agendamento WHERE empresa_id = $id");
	    	}
	    	$query = $conexao->query("SELECT * FROM ponto WHERE empresa_id = $id");
	    	while ($row = $query->fetch_assoc()){
	    		$ponto_id = $row["id"];
	    		$sub_query = $conexao->query("DELETE FROM endereco_has_ponto WHERE ponto_id = $ponto_id");
	    		$sub_query = $conexao->query("DELETE FROM tipo_lixo_has_ponto WHERE ponto_id = $ponto_id");
	    		$sub_query = $conexao->query("DELETE FROM ponto WHERE empresa_id = $id");
	    	}
	    	$query = $conexao->query("DELETE FROM empresa WHERE id = $id");
	    	$retorno = false;
	    	$query = $conexao->query("SELECT * FROM empresa WHERE id = $id");
	    	if (mysqli_num_rows($query) == 0)
	    		$retorno = true;
			$conexao->close();
	  		return $retorno;
	    }
	    function login($email,$senha) {
			$email = preg_replace('![*#/\"´`]+!','',$email);
			$senha = sha1($senha);
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM empresa WHERE email = '$email' AND senha = '$senha'");
			$retorno = 0;
			if (mysqli_num_rows($query) == 1)
			{
				$row = mysqli_fetch_assoc($query);
				$retorno = $row["id"];
			}
			$conexao->close();
			return $retorno;
		}
		function select_by_id($id) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM empresa WHERE id = $id");
			$dados = array();
			while($row = mysqli_fetch_assoc($query))
			    $dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}
		function select($condicoes) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			if ($condicoes != NULL)
				$condicoes = "WHERE " . $condicoes;
			$query = $conexao->query("SELECT * FROM empresa $condicoes");
			$dados = array();
			while($row = mysqli_fetch_assoc($query))
			    $dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}
	}
	// Registro dos métodos da classe empresa //
	$server->register('empresa.insert', array('razao_social' => 'xsd:string','nome_fantasia' => 'xsd:string','cnpj' => 'xsd:string','senha' => 'xsd:string','email' => 'xsd:string','agendamento' => 'xsd:integer'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Insere um registro na table empresa (retorna o id do registro inserido).');
	$server->register('empresa.update_perfil', array('id' => 'xsd:integer','razao_social' => 'xsd:string','nome_fantasia' => 'xsd:string','email' => 'xsd:string','agendamento' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Altera um registro da tabela empresa.');
	$server->register('empresa.update_senha', array('id' => 'xsd:integer','senha_antiga' => 'xsd:string','senha_nova' => 'xsd:string'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Altera a senha de uma empresa testando se a senha que ela digitou é a que está registrada.');
	$server->register('empresa.delete', array('id' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Deleta um registro da tabela empresa.');
	$server->register('empresa.login', array('email' => 'xsd:string','senha' => 'xsd:string'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Pesquisa um registro da tabela empresa por login e senha (sem criptografia e retorna id).');
	$server->register('empresa.select_by_id', array('id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa registros da tabela empresa por id (retorna json).');
	$server->register('empresa.select', array('condicoes' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa registros da tabela empresa com condições definidas ou indefinidas (retorna json).');

	// Classe da tabela ponto //
	class ponto {
	    function insert($empresa_id,$atendimento_ini,$atendimento_fim,$observacao,$telefone,$endereco_id) {
	    	$atendimento_ini = preg_replace("![^0-9:]+!",'',$atendimento_ini);
			$atendimento_fim = preg_replace("![^0-9:]+!",'',$atendimento_fim);
			$observacao = preg_replace('![*#/\"´`]+!','',$observacao);
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	    	$query = $conexao->query("INSERT INTO ponto VALUES(NULL,$empresa_id,'$atendimento_ini','$atendimento_fim','$observacao','$telefone',$endereco_id)");
	    	$id = 0;
	    	if ($query == true)
	    		$id = $conexao->insert_id;
			$conexao->close();
	      	return $id;
	    }
	    function update($id,$atendimento_ini,$atendimento_fim,$observacao,$telefone) {
	    	$atendimento_ini = preg_replace("![^0-9:]+!",'',$atendimento_ini);
			$atendimento_fim = preg_replace("![^0-9:]+!",'',$atendimento_fim);
			$observacao = preg_replace('![*#/\"´`]+!','',$observacao);
	     	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	     	$retorno = false;
	    	$query = $conexao->query("SELECT * FROM ponto WHERE id = $id");
			if (mysqli_num_rows($query) == 1)
			{
		    	$query = $conexao->query("UPDATE ponto SET atendimento_ini = '$atendimento_ini',atendimento_fim = '$atendimento_fim', observacao = '$observacao', telefone = '$telefone' WHERE id = $id");
				$retorno = true;
			}
			$conexao->close();
	     	return $retorno;
	    }
	    function delete($id) {
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
    		$query = $conexao->query("DELETE FROM tipo_lixo_has_ponto WHERE ponto_id = $id");
    		$query = $conexao->query("SELECT endereco_id FROM ponto WHERE id = $id");
    		$endereco_id = mysqli_fetch_assoc($query);
    		$endereco_id = $endereco_id["endereco_id"];
    		$query = $conexao->query("DELETE FROM ponto WHERE id = $id");
    		$query = $conexao->query("DELETE FROM endereco WHERE id = $endereco_id");
    		$retorno = false;
	    	$query = $conexao->query("SELECT * FROM ponto WHERE id = $id");
	    	if (mysqli_num_rows($query) == 0)
	    		$retorno = true;
			$conexao->close();
	  		return $retorno;
	    }
		function select_by_atendimento($atendimento) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM ponto WHERE atendimento_ini < '$atendimento' AND atendimento_fim > '$atendimento'");
			$dados = array();
			while($row = mysqli_fetch_assoc($query))
			    $dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}
		function select_by_empresa($empresa_id) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM ponto WHERE empresa_id = $empresa_id");
			$dados = array();
			while($row = mysqli_fetch_assoc($query))
			    $dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}
		function select_by_id($id) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM ponto WHERE id = $id");
			$dados = array();
			while($row = mysqli_fetch_assoc($query))
			    $dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}
		function select($condicoes) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			if ($condicoes != NULL)
				$condicoes = "WHERE " . $condicoes;
			$query = $conexao->query("SELECT * FROM ponto $condicoes");
			$dados = array();
			while($row = mysqli_fetch_assoc($query))
			    $dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}
		function select_by_coordenadas($latitude,$longitude) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT ponto.id,ponto.empresa_id,ponto.atendimento_ini,ponto.atendimento_fim,ponto.observacao,ponto.telefone,ponto.endereco_id FROM ponto INNER JOIN endereco ON (ponto.endereco_id = endereco.id) WHERE abs(endereco.latitude-$latitude) < 0.4 AND abs(endereco.longitude-$longitude) < 0.4");
			$dados = array();
			while($row = mysqli_fetch_assoc($query))
			    $dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}
	}
	// Registro dos métodos da classe ponto //
	$server->register('ponto.insert', array('empresa_id' => 'xsd:integer','atendimento_ini' => 'xsd:string','atendimento_fim' => 'xsd:string','observacao' => 'xsd:string','telefone' => 'xsd:string','endereco_id' => 'xsd:integer'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Insere um registro na tabela ponto (retorna o id do registro inserido).');
	$server->register('ponto.update', array('id' => 'xsd:integer','atendimento_ini' => 'xsd:string','atendimento_fim' => 'xsd:string','observacao' => 'xsd:string','telefone' => 'xsd:string'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Altera um registro da tabela ponto.');
	$server->register('ponto.delete', array('id' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Deleta um registro da tabela ponto.');
	$server->register('ponto.select_by_atendimento', array('atendimento' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa registros da tabela ponto por horário de atendimento (retorna json).');
	$server->register('ponto.select_by_empresa', array('empresa_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa registros da tabela ponto por empresa (retorna json).');
	$server->register('ponto.select_by_id', array('id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa registros da tabela ponto por id (retorna json).');
	$server->register('ponto.select', array('condicoes' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa registros da tabela ponto com condições definidas ou indefinidas (retorna json).');
	$server->register('ponto.select_by_coordenadas', array('latitude' => 'xsd:double','longitude' => 'xsd:double'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa registros da tabela ponto pela distância da casa do usuário (retorna json).');

	// Classe da tabela tipo_lixo_has_ponto //
	class tipo_lixo_has_ponto {
		function insert($tipo_lixo_id,$ponto_id) {
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	 
	    	$query = $conexao->query("INSERT INTO tipo_lixo_has_ponto VALUES(NULL,$tipo_lixo_id,$ponto_id)");
	    	$id = 0;
	    	if ($query == true)
	    		$id = $conexao->insert_id;
			$conexao->close();
	      	return $id;
	    }
	    function delete($id) {
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	 
    		$query = $conexao->query("DELETE FROM tipo_lixo_has_ponto WHERE id = $id");
    		$retorno = false;
	    	$query = $conexao->query("SELECT * FROM tipo_lixo_has_ponto WHERE id = $id");
	    	if (mysqli_num_rows($query) == 0)
	    		$retorno = true;
			$conexao->close();
	  		return $retorno;
	    }
	    function select_by_id($id) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM tipo_lixo_has_ponto WHERE id = $id");
			$dados = array();
			while($row = mysqli_fetch_assoc($query))
			    $dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}
		function select_by_ponto($ponto_id) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM tipo_lixo_has_ponto WHERE ponto_id = $ponto_id");
			$dados = array();
			while($row = mysqli_fetch_assoc($query))
			    $dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}
		function select($condicoes) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			if ($condicoes != NULL)
				$condicoes = "WHERE " . $condicoes;
			$query = $conexao->query("SELECT * FROM tipo_lixo_has_ponto $condicoes");
			$dados = array();
			while($row = mysqli_fetch_assoc($query))
			    $dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}
	}
	// Registro dos métodos da classe tipo_lixo_has_ponto //
	$server->register('tipo_lixo_has_ponto.insert', array('tipo_lixo_id' => 'xsd:integer','ponto_id' => 'xsd:integer'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Insere um registro na tabela tipo_lixo_has_ponto (retorna o id do registro inserido).');
	$server->register('tipo_lixo_has_ponto.delete', array('id' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Deleta um registro da tabela tipo_lixo_has_ponto.');
	$server->register('tipo_lixo_has_ponto.select_by_id', array('id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa um registro da tabela tipo_lixo_has_ponto por id (retorna json).');
	$server->register('tipo_lixo_has_ponto.select_by_ponto', array('ponto_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa um registro da tabela tipo_lixo_has_ponto por empresa_id (retorna json).');
	$server->register('tipo_lixo_has_ponto.select', array('condicoes' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa registros da tipo_lixo_has_ponto ponto com condições definidas ou indefinidas (retorna json).');

	// Classe da tabela notificacao //
	class notificacao {
	    function insert($usuario_id,$empresa_id,$tipo,$destino) {
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	    	$query = $conexao->query("INSERT INTO notificacao VALUES(NULL,$usuario_id,$empresa_id,$tipo,$destino,0)");
	    	$id = 0;
	    	if ($query == true)
	    		$id = $conexao->insert_id;
			$conexao->close();
	      	return $id;
	    }
	    function delete($id) {
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	    	$query = $conexao->query("DELETE FROM notificacao WHERE id = $id");
	    	$retorno = false;
	    	$query = $conexao->query("SELECT * FROM notificacao WHERE id = $id");
	    	if (mysqli_num_rows($query) == 0)
	    		$retorno = true;
			$conexao->close();
	  		return $retorno;
	    }
		function select_by_usuario($usuario_id) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM notificacao WHERE usuario_id = $usuario_id AND destino = 0 ORDER BY id ASC");
			$dados = array();
			while($row = mysqli_fetch_assoc($query)) {
			    $dados[] = $row;
			}
			$conexao->close();
			return json_encode($dados);
		}
		function select_nao_visualizados_by_usuario($usuario_id) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM notificacao WHERE usuario_id = $usuario_id AND destino = 0 AND visualizado = 0");
			$dados = array();
			while($row = mysqli_fetch_assoc($query)) {
			    $dados[] = $row;
			}
			$conexao->close();
			return json_encode($dados);
		}
		function visualizar_todos_by_usuario($usuario_id){
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	    	$query = $conexao->query("UPDATE notificacao SET visualizado = 1 WHERE usuario_id = $usuario_id AND destino = 0");
			$conexao->close();
	     	return $query;
		}
		function select_by_empresa($empresa_id) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM notificacao WHERE empresa_id = $empresa_id AND destino = 1 ORDER BY id ASC");
			$dados = array();
			while($row = mysqli_fetch_assoc($query)) {
			    $dados[] = $row;
			}
			$conexao->close();
			return json_encode($dados);
		}
		function select_nao_visualizados_by_empresa($empresa_id) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM notificacao WHERE empresa_id = $empresa_id AND destino = 1 AND visualizado = 0");
			$dados = array();
			while($row = mysqli_fetch_assoc($query)) {
			    $dados[] = $row;
			}
			$conexao->close();
			return json_encode($dados);
		}
		function visualizar_todos_by_empresa($empresa_id){
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	    	$query = $conexao->query("UPDATE notificacao SET visualizado = 1 WHERE empresa_id = $empresa_id AND destino = 1");
			$conexao->close();
	     	return $query;
		}

	}
	// Registro dos métodos da classe notificacao //
	$server->register('notificacao.insert', array('usuario_id' => 'xsd:string','empresa_id' => 'xsd:string','tipo' => 'xsd:integer','destino' => 'xsd:integer'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Insere um registro na tabela notificacao (retorna o id do registro inserido).');
	$server->register('notificacao.delete', array('id' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Deleta um registro da tabela notificacao.');
	$server->register('notificacao.select_by_usuario', array('usuario_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa um registro da tabela notificacao por usuario (retorna json).');
	$server->register('notificacao.select_nao_visualizados_by_usuario', array('usuario_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa um registros não visualizados da tabela notificacao por usuario (retorna json).');
	$server->register('notificacao.visualizar_todos_by_usuario', array('usuario_id' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Visualiza todos as notificações por usuario (retorna json).');
	$server->register('notificacao.select_by_empresa', array('empresa_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa um registro da tabela notificacao por empresa (retorna json).');
	$server->register('notificacao.select_nao_visualizados_by_empresa', array('empresa_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa um registros não visualizados da tabela notificacao por empresa (retorna json).');
	$server->register('notificacao.visualizar_todos_by_empresa', array('empresa_id' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Visualiza todos as notificações por empresa (retorna json).');

	// Classe da tabela agendamento //
	class agendamento {
	    function insert($empresa_id,$usuario_id,$data_agendamento,$horario, $endereco_id) {
	    	$data_agendamento = preg_replace("![^0-9/]+!",'',$data_agendamento);
    		$data_agendamento = DateTime::createFromFormat('d/m/Y',$data_agendamento);
    		$data_agendamento = $data_agendamento->format('Y-m-d');
			$horario = preg_replace("![^0-9:]+!",'',$horario);
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	    	$query = $conexao->query("INSERT INTO agendamento VALUES(NULL,$empresa_id,$usuario_id,'$data_agendamento','$horario',0,0,$endereco_id,NULL)");
	    	$id = 0;
	    	if ($query == true)
	    	{
	    		$id = $conexao->insert_id;
	    		$query = $conexao->query("INSERT INTO notificacao VALUES(NULL,$usuario_id,$empresa_id,2,1)");
	    	}
			$conexao->close();
	      	return $id;
	    }
	    function aceitar($id) {
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	     	$retorno = false;
	    	$query = $conexao->query("SELECT * FROM agendamento WHERE id = $id");
	    	$row = mysqli_fetch_assoc($query);
			if ((mysqli_num_rows($query) == 1) && ($row["aceito"] == 0))
			{
		    	$query = $conexao->query("UPDATE agendamento SET aceito = 1 WHERE id = $id");
		    	$retorno = true;
		    	$query = $conexao->query("INSERT INTO notificacao VALUES(NULL,".$row["usuario_id"].",".$row["empresa_id"].",0,0)");
			}
			$conexao->close();
	     	return $retorno;
	    }
	    function recusar($id) {
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	     	$retorno = false;
	    	$query = $conexao->query("SELECT * FROM agendamento WHERE id = $id");
	    	$row = mysqli_fetch_assoc($query);
			if ((mysqli_num_rows($query) == 1) && ($row["aceito"] == 0))
			{
		    	$query = $conexao->query("INSERT INTO notificacao VALUES(NULL,".$row["usuario_id"].",".$row["empresa_id"].",1,0)");
				$query = $conexao->query("DELETE FROM agendamento_has_tipo_lixo WHERE agendamento_id = $id");
		    	$query = $conexao->query("DELETE FROM agendamento WHERE id = $id");
		    	$retorno = true;
			}
			$conexao->close();
	     	return $retorno;
	    }
	    function realizar($id) {
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	     	$retorno = false;
	    	$query = $conexao->query("SELECT * FROM agendamento WHERE id = $id");
	    	$row = mysqli_fetch_assoc($query);
			if ((mysqli_num_rows($query) == 1) && ($row["aceito"] == 1) && ($row["realizado"] == 0))
			{
		    	$query = $conexao->query("UPDATE agendamento SET realizado = 1 WHERE id = $id");
		    	$retorno = true;
			}
			$conexao->close();
	     	return $retorno;
	    }
	    function cancelar($id,$justificativa) {
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	     	$retorno = false;
	    	$query = $conexao->query("SELECT * FROM agendamento WHERE id = $id");
	    	$row = mysqli_fetch_assoc($query);
			if ((mysqli_num_rows($query) == 1) && ($row["realizado"] == 0))
			{
		    	$query = $conexao->query("UPDATE agendamento SET aceito = 0, realizado = 1, justificativa = '$justificativa' WHERE id = $id");
		    	$retorno = true;
		    	$query = $conexao->query("INSERT INTO notificacao VALUES(NULL,".$row["usuario_id"].",".$row["empresa_id"].",3,1)");
			}
			$conexao->close();
	     	return $retorno;
	    }
		function select_sem_resposta_by_usuario($usuario_id) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM agendamento WHERE usuario_id = $usuario_id AND aceito = 0 AND realizado = 0");
			$dados = array();
			while($row = mysqli_fetch_assoc($query)) {
			    $dados[] = $row;
			}
			$conexao->close();
			return json_encode($dados);
		}
		function select_aceitos_by_usuario($usuario_id) {
			$data = date("Y-m-d");
			$horario = date("H:i");
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM agendamento WHERE usuario_id = $usuario_id AND aceito = 1 AND realizado = 0 AND data_agendamento >= '$data' ORDER BY data_agendamento, horario DESC");
			$dados = array();
			while($row = mysqli_fetch_assoc($query)) {
			    $dados[] = $row;
			}
			$conexao->close();
			return json_encode($dados);
		}
		function select_realizados_by_usuario($usuario_id) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM agendamento WHERE usuario_id = $usuario_id AND aceito = 1 AND realizado = 1 ORDER BY data_agendamento, horario DESC");
			$dados = array();
			while($row = mysqli_fetch_assoc($query)) {
			    $dados[] = $row;
			}
			$conexao->close();
			return json_encode($dados);
		}
		function select_atrasados_by_usuario($usuario_id) {
			$data = date("Y-m-d");
			$horario = date("H:i");
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM agendamento WHERE usuario_id = $usuario_id AND aceito = 1 AND realizado = 0 AND data_agendamento < '$data' AND horario < '$horario' ORDER BY data_agendamento, horario DESC");
			$dados = array();
			while($row = mysqli_fetch_assoc($query)) {
			    $dados[] = $row;
			}
			$conexao->close();
			return json_encode($dados);
		}
		function select_cancelados_by_usuario($usuario_id) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM agendamento WHERE usuario_id = $usuario_id AND aceito = 0 AND realizado = 1 ORDER BY data_agendamento, horario DESC");
			$dados = array();
			while($row = mysqli_fetch_assoc($query)) {
			    $dados[] = $row;
			}
			$conexao->close();
			return json_encode($dados);
		}
		function select_sem_resposta_by_empresa($empresa_id) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM agendamento WHERE empresa_id = $empresa_id AND aceito = 0 AND realizado = 0");
			$dados = array();
			while($row = mysqli_fetch_assoc($query)) {
			    $dados[] = $row;
			}
			$conexao->close();
			return json_encode($dados);
		}

		function select_aceitos_by_empresa($empresa_id) {
			$data = date("Y-m-d");
			$horario = date("H:i");
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM agendamento WHERE empresa_id = $empresa_id AND aceito = 1 AND realizado = 0 AND data_agendamento >= '$data' ORDER BY data_agendamento, horario DESC");
			$dados = array();
			while($row = mysqli_fetch_assoc($query)) {
			    $dados[] = $row;
			}
			$conexao->close();
			return json_encode($dados);
		}
		function select_realizados_by_empresa($empresa_id) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM agendamento WHERE empresa_id = $empresa_id AND aceito = 1 AND realizado = 1 ORDER BY data_agendamento, horario DESC");
			$dados = array();
			while($row = mysqli_fetch_assoc($query)) {
			    $dados[] = $row;
			}
			$conexao->close();
			return json_encode($dados);
		}
		function select_atrasados_by_empresa($empresa_id) {
			$data = date("Y-m-d");
			$horario = date("H:i");
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM agendamento WHERE empresa_id = $empresa_id AND aceito = 1 AND realizado = 0  AND data_agendamento < '$data' AND horario < '$horario' ORDER BY data_agendamento, horario DESC");
			$dados = array();
			while($row = mysqli_fetch_assoc($query)) {
			    $dados[] = $row;
			}
			$conexao->close();
			return json_encode($dados);
		}
		function select_cancelados_by_empresa($empresa_id) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM agendamento WHERE empresa_id = $empresa_id AND aceito = 0 AND realizado = 1 ORDER BY data_agendamento, horario DESC");
			$dados = array();
			while($row = mysqli_fetch_assoc($query)) {
			    $dados[] = $row;
			}
			$conexao->close();
			return json_encode($dados);
		}
		function select($condicoes) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			if ($condicoes != NULL)
				$condicoes = "WHERE " . $condicoes;
			$query = $conexao->query("SELECT * FROM agendamento $condicoes");
			$dados = array();
			while($row = mysqli_fetch_assoc($query))
			    $dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}
	}
	// Registro dos métodos da classe agendamento //
	$server->register('agendamento.insert', array('empresa_id' => 'xsd:integer','usuario_id' => 'xsd:integer','data_agendamento' => 'xsd:string','horario' => 'xsd:string','endereco_id' => 'xsd:integer'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Insere um registro na tabela agendamento (retorna o id do registro inserido).');
	$server->register('agendamento.aceitar', array('id' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Aceita um agendamento.');
	$server->register('agendamento.recusar', array('id' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Recusa um agendamento.');
	$server->register('agendamento.realizar', array('id' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Realiza um agendamento.');
	$server->register('agendamento.cancelar', array('id' => 'xsd:integer', 'justificativa' => 'xsd:string'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Aceita um agendamento.');
	$server->register('agendamento.select_sem_resposta_by_usuario', array('usuario_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa agendamentos sem reposta da tabela agendamento por usuario (retorna json).');
	$server->register('agendamento.select_aceitos_by_usuario', array('usuario_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa agendamentos pendentes da tabela agendamento por usuario (retorna json).');
	$server->register('agendamento.select_realizados_by_usuario', array('usuario_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa agendamentos sem reposta da tabela agendamento por usuario (retorna json).');
	$server->register('agendamento.select_atrasados_by_usuario', array('usuario_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa agendamentos atrasados da tabela agendamento por usuario (retorna json).');
	$server->register('agendamento.select_cancelados_by_usuario', array('usuario_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa agendamentos cancelados da tabela agendamento por usuario (retorna json).');
	$server->register('agendamento.select_sem_resposta_by_empresa', array('empresa_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa agendamentos sem reposta da tabela agendamento por usuario (retorna json).');
	$server->register('agendamento.select_aceitos_by_empresa', array('empresa_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa agendamentos pendentes da tabela agendamento por usuario (retorna json).');
	$server->register('agendamento.select_realizados_by_empresa', array('empresa_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa agendamentos sem reposta da tabela agendamento por usuario (retorna json).');
	$server->register('agendamento.select_atrasados_by_empresa', array('empresa_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa agendamentos atrasados da tabela agendamento por empresa (retorna json).');
	$server->register('agendamento.select_cancelados_by_empresa', array('empresa_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa agendamentos cancelados da tabela agendamento por usuario (retorna json).');
	$server->register('agendamento.select', array('condicoes' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa registros com condições definidas ou indefinidas (retorna json).');

	// Classe da tabela agendamento_has_tipo_lixo //
	class agendamento_has_tipo_lixo {
	    function insert($tipo_lixo_id,$agendamento_id,$quantidade) {
	    	$quantidade = ereg_replace("[^0-9.]", '',$quantidade);
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	    	$query = $conexao->query("INSERT INTO agendamento_has_tipo_lixo VALUES(NULL,$tipo_lixo_id,$agendamento_id,$quantidade)");
	    	$id = 0;
	    	if ($query == true)
	    		$id = $conexao->insert_id;
			$conexao->close();
	      	return $id;
	    }
	    function update($id,$quantidade) {
	    	$quantidade = ereg_replace("[^0-9.]", '',$quantidade);
	     	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	     	$retorno = false;
	    	$query = $conexao->query("SELECT * FROM agendamento_has_tipo_lixo WHERE id = $id");
			if (mysqli_num_rows($query) == 1)
			{
		    	$query = $conexao->query("UPDATE agendamento_has_tipo_lixo SET quantidade = $quantidade WHERE id = $id");
				$retorno = true;
			}
			$conexao->close();
	     	return $retorno;
	    }
	    function delete($id) {
	    	$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
	    	$query = $conexao->query("DELETE FROM agendamento_has_tipo_lixo WHERE id = $id");
	    	$retorno = false;
	    	$query = $conexao->query("SELECT * FROM agendamento_has_tipo_lixo WHERE id = $id");
	    	if (mysqli_num_rows($query) == 0)
	    		$retorno = true;
			$conexao->close();
	  		return $retorno;
	    }
		function select_by_agendamento($agendamento_id) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM agendamento_has_tipo_lixo WHERE agendamento_id = $agendamento_id");
			$dados = array();
			while($row = mysqli_fetch_assoc($query)) {
			    $dados[] = $row;
			}
			$conexao->close();
			return json_encode($dados);
		}
		function select($condicoes) {
			$conexao = new mysqli("localhost","root","serverweb","descarteslab");
			$query = $conexao->query('SET CHARACTER SET utf8');
			if ($condicoes != NULL)
				$condicoes = "WHERE " . $condicoes;
			$query = $conexao->query("SELECT * FROM agendamento_has_tipo_lixo $condicoes");
			$dados = array();
			while($row = mysqli_fetch_assoc($query))
			    $dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}
	}
	// Registro dos métodos da classe agendamento_has_tipo_lixo //
	$server->register('agendamento_has_tipo_lixo.insert', array('tipo_lixo_id' => 'xsd:integer','agendamento_id' => 'xsd:integer','quantidade' => 'xsd:double'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Insere um registro na tabela agendamento_has_tipo_lixo (retorna o id do registro inserido).');
	$server->register('agendamento_has_tipo_lixo.update', array('quantidade' => 'xsd:double'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Insere um registro na tabela agendamento_has_tipo_lixo (retorna o id do registro inserido).');
	$server->register('agendamento_has_tipo_lixo.delete', array('id' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Deleta um registro da tabela agendamento_has_tipo_lixo.');
	$server->register('agendamento_has_tipo_lixo.select_by_agendamento', array('agendamento_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa um registro da tabela agendamento_has_tipo_lixo por agendamento (retorna json).');
	$server->register('agendamento_has_tipo_lixo.select', array('condicoes' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Pesquisa registros com condições definidas ou indefinidas (retorna json).');

	$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
	$server->service($HTTP_RAW_POST_DATA);
?>