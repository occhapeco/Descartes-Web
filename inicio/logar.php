<?php
    if(isset($_POST["email"]))
    {
        $email = $_POST["email"];
        $senha = $_POST["senha"];

        require_once("../conectar_service.php");

        $empresa = $service->call('empresa.login',array($email,$senha,true));
        var_dump($empresa);
        if ($empresa != 0)
        {   
            session_start();
            $_SESSION["id"] = $empresa;
            $_SESSION["tabela"] = "empresa";
            header("location: ../empresa/");
        }
        else
        {
            $usuario = $service->call('usuario.login',array($email,$senha,true));
            if ($usuario != 0)
            {
                session_start();
                $_SESSION["id"] = $usuario;
                $_SESSION["tabela"] = "usuario";
                header("location: ../usuario/");
            }
            else
                header("location: login.php");
        }     
    }
?>