<?php
	require_once('endereco.class.php');
	//require_once('outros.class.php');

	
	class Eleitor
	{
		private $cod_eleitor;
		private $nome;
		private $sexo;
		private $aniversario;
		private $cpf;
		private $tipo;
		private $filho;
		private $ende;

		function getEnde()
		{
			return $en = new Endereco;
		}

		function getCod()
		{
			return $this->cod_eleitor;
		}

		function getNome()
		{
			return $this->nome;
		}
		function setNome($valor)
		{
			$this->nome = $valor;
		}

		function getSexo()
		{
			return $this->$sexo;
		}
		function setSexo($valor)
		{
			$this->sexo = $valor;
		}

		function getAniversario()
		{
			return $this->$aniversario;
		}
		function setAniversario($valor)
		{
			$this->aniversario = $valor;
		}

		function getCpf()
		{
			return $this->$cpf;
		}
		function setCpf($valor)
		{
			$this->$cpf = $valor;
		}

		function getTipo()
		{
			return $this->$tipo;
		}
		function setTipo($valor)
		{
			$this->$tipo = $valor;
		}

		function getFilho()
		{
			return $this->$filho;
		}
		function setFilho($valor)
		{
			$this->$filho = $valor;
		}

	}

?>