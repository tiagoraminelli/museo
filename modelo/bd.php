<?php

class Db {

	private $host;
	private $db;
	private $user;
	private $pass;
	public $conection;

	public function __construct($host='localhost',$db_name='museo',$db_user='root',$db_pass='') {		

		$this->host = $host;
		$this->db = $db_name;
		$this->user = $db_user;
		$this->pass = $db_pass;

		try { //se pone try se abre {}, luego se invoca el catch
		//este try realiza la conexion;
		//todo el codigo que este aca si aparece un error aca dentro lo captura el PHP con PDOexception

           $this->conection = new PDO('mysql:host='.$this->host.'; dbname='.$this->db, $this->user, $this->pass);
            
        } catch (PDOException $e) { //PDOException un error que lo maneja la libreria 
            echo $e->getCode()." ; ".$e->getMessage();

            exit();
        }

	}

}