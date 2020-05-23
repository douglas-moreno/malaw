<?php

	class Endereco
	{
		protected $endereco;
		protected $numero;
		protected $bairro;
		protected $complemento;
		protected $ciade;
		protected $estado;
		protected $regiao;
		protected $cep;
		protected $telefone;
		protected $email;

		function set($campo, $valor)
		{
			$this->$campo = $valor;
		}

		function get($campo)
		{
			return $this->$campo;
		}
	}

?>