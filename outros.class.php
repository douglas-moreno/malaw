<?php

	class Outros
	{
		protected $tel2;
		protected $tel3;
		protected $celular;
		protected $obs;

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