<?php
    if(count($_POST) > 0) {
    // 1.pegar os valores do formulario
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    // 2.conexão com banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=restaurante_bd", $username, $password);
        // defina o modo de erro PDO para exceção
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Conexão realizada com sucesso.";
        // 3.verificar se email e senha estão no bando de dados
        $stmt = $conn->prepare("SELECT codigo FROM usuario WHERE email=:email AND senha=md5(:senha)");
        $stmt->bindParam(':email' , $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha' , $senha, PDO::PARAM_STR);
        $stmt->execute();

  // set the resulting array to associative
  $result = $stmt->fetchAll();
  $qtd_usuarios = count($result);
  if($qtd_usuarios ==1) {
    //   TODO substituir pel redirecionamento...
      $resultado ["msg"] = "Usuario encontrado!";
      $resultado ["cod"] = 1;
  } else if ($qtd_usuarios ==0){
      $resultado["msg"] = "Usario não encontrado..";
      $resultado["cod"] = 0;
  }

  }
  catch(PDOException $e) {
        echo "Conexão falhou: " . $e->getMessage();
}
$conn = null;
}
include("index.php");



?>