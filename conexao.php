<?php
      try{
      $conexao = new PDO('mysql:host=localhost;dbname=softdesignercom_sorveteria;charset=utf8','softdesignercom_engenheiro','Sedex@2025',array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8'));
      $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch (PDOException $e){
        echo 'Erro na conexãoo:' .$e->getMessage().'<br>';
        echo 'Código do erro:' .$e->getCode();
      }
 ?>