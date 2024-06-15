<?php
//http://localhost/projects/testes.php
//$this é o mesmo que self
//não podemos mudar o nome de $this
class classe {
    public $nome;
    public $age;
    
    function __construct($nome, $age) {
        $this->nome = $nome;
        $this->age = $age;
    }
}

class classe2 {
}