<?php

class Number extends Element
{
	public $id = null;
	public $number = null;
	public $active = null;
	public $contract = null;

	public function __construct($properties = array())
	{
		foreach ($properties as $key => $value)
		{
			$this->$key = $value;
		}
	}

	public function __toString()
	{
		return get_class($this) . ' id=' . $this->id;
	}
}