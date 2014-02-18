<?php

class Contract extends Element
{
	public $expirationDate = null;

	public function __construct($properties)
	{
		foreach ($properties as $key => $value)
		{
			$this->$key = $value;
		}
	}

	public function __toString()
	{
		return get_class($this);
	}
} 