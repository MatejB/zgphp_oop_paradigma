<?php

class Tariff extends Element
{
	public $id = null;

	public function __construct($id)
	{
		$this->id = $id;
	}

	public function __toString()
	{
		return get_class($this) . ' id=' . $this->id;
	}
}