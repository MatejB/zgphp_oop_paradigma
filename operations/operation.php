<?php

abstract class Operation
{
	const OPERATION_CONTINUE = 101;
	const OPERATION_BREAK = 102;

	protected $_validators = array();
	protected $_elements = array();

	public function acceptValidator(Validator $validator)
	{
		$this->_validators[] = $validator;
	}

	public function acceptElement($element)
	{
		if (!is_object($element))
		{
			throw new InvalidArgumentException('acceptElement receives only objects!');
		}
		$this->_elements[] = $element;
	}

	public function validOperation()
	{
		$anyValid = false;

		foreach ($this->_elements as $element)
		{
			foreach ($this->_validators as $validator)
			{
				$is_valid = $validator->runValidation($element);

				if (null === $is_valid)
				{
					continue;
				}

				if (false === $is_valid)
				{
					$onInvalidResult = $this->onInvalid($element, $validator);

					if (self::OPERATION_CONTINUE === $onInvalidResult)
					{
						continue;
					}
					elseif (self::OPERATION_BREAK === $onInvalidResult)
					{
						return false;
					}
				}

				$anyValid = true;
				$onValidResult = $this->onValid($element, $validator);

				if (self::OPERATION_CONTINUE === $onValidResult)
				{
					continue;
				}
				elseif (self::OPERATION_BREAK === $onValidResult)
				{
					return true;
				}
			}
		}

		return $anyValid;
	}

	public function onInvalid($element, $validator)
	{
		echo '<div style="padding: 20px; width: 400px; text-align: center; color: white; background-color: red;">' . get_class($this) . ' validation failed because of ' . $element . ' on validator ' . $validator . '</div>' . "<br>\n<br>\n";
		return self::OPERATION_BREAK;
	}

	public function onValid($element, $validator)
	{
		echo '<div style="padding: 20px; width: 400px; text-align: center; color: white; background-color: green;">' . get_class($this) . ' validation success on ' . $element . ' on validator ' . $validator . '</div>' . "<br>\n<br>\n";
		return self::OPERATION_CONTINUE;
	}

	abstract public function execute();
} 