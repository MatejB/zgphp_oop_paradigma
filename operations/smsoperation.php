<?php

class SmsOperation extends Operation
{
	public function __construct(Number $numberA, Number $numberB)
	{
		$this->acceptElement($numberA);
		$this->acceptElement($numberB);
	}

	public function execute()
	{
		echo '<div style="padding: 20px; width: 400px; text-align: center; color: white; background-color: green;">' . get_class($this) . ' executed!</div>' . "<br>\n<br>\n";
	}
} 