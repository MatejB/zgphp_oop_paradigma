<?php

class TariffChangeOperation extends Operation
{
	public function __construct(Tariff $tariff, $numbers)
	{
		$this->acceptElement($tariff);
		foreach ($numbers as $number)
		{
			$this->acceptElement($number);
		}
	}

	public function onInvalid($element, $validator)
	{
		parent::onInvalid($element, $validator);

		return self::OPERATION_CONTINUE;
	}

	public function execute()
	{
		echo '<div style="padding: 20px; width: 400px; text-align: center; color: white; background-color: green;">' . get_class($this) . ' executed!</div>' . "<br>\n<br>\n";
	}
} 