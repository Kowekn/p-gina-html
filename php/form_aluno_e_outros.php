<!DOCTYPE html>
<html lang="pt">
<head>
    <title>Página de Submit</title>
    <link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<section>
<?php /*http://localhost/projects/form_aluno_e_outros.php para ver funcionando */
    $cn = new PDO("pgsql:dbname=teste;host=localhost", "postgres", "12345");
    if ($cn) {
        echo "Conectado ao servidor.<br>";
        
    }else {
        echo "Não foi possível conectar ao servidor, cheque sua conexão.<br>";
    }
    
    

    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $sexo = $_POST["sexo"];
    $dtnascimento = $_POST["dtnascimento"];
    $senha = $_POST["senha"];
    
    //$date=date("Y.m.d", strtotime($dtnascimento));
    $date=date("Y-m-d H:i:s", strtotime($dtnascimento));
    $senha = password_hash($senha, PASSWORD_BCRYPT);
    
    $sql1 = "INSERT INTO aluno (nome, cpf, sexo, dtnascimento, senha)
    VALUES(:nome,:cpf,:sexo,:dtnascimento, :senha)";
    
    $smt = $cn->prepare($sql1);

    $smt->bindValue(":nome", $nome);
    $smt->bindValue(":cpf", $cpf);
    $smt->bindValue(":sexo", $sexo);
    $smt->bindValue(":dtnascimento", $dtnascimento, PDO::PARAM_STR);
    $smt->bindValue(":senha", $senha);

    try {
        $smtca = $cn->prepare("SELECT setval('aluno_codigoaluno_seq',
        COALESCE((SELECT MAX(codigoaluno)+1 FROM aluno), 1), false)");
        $smtca->execute();
        $smt->execute();
        echo "Transferência completa<br>";
     } catch (PDOException $e) {
        if ($e->errorInfo[1] == 7) {
            echo "CPF já registrado em banco de dados!<br>";
            
            
           // se o erro for de duplicata em alguma coluna UNIQUE
        } else {
            echo "Ocorreu algum erro, tente novamente!<br>";
           
           // outro erro
        }
        
     }
    
    
    #$smt->execute();
    #(":date", strtotime (date ("Y-m-d H:i:s")), PDO::PARAM_STR);
    #$newDate = date("d-m-Y", strtotime($originalDate));
?>
</section>
<section>
    <div>
        <?php
    echo "<table style='border: solid 1px black;'>";
    echo "<tr><th>ID</th><th>Nome</th><th>CPF</th><th>Sexo</th><th>Data de Nascimento</th></tr>";
    
    class TableRows extends RecursiveIteratorIterator {
      function __construct($it) {
        parent::__construct($it, self::LEAVES_ONLY);
      }
    
      function current() {
        return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
      }
    
      function beginChildren() {
        echo "<tr>";
      }
      
    
      function endChildren() {
        echo "</tr>" . "\n";
      }
    }
    try {
        $cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $cn->prepare("SELECT codigoaluno, nome, cpf, sexo, dtnascimento FROM aluno");
        $stmt->execute();
      
        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach (new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
          echo $v;
        }
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      
      echo "</table>";
  ?>
    </div>
</section>
</body>
</html>