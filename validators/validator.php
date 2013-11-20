<?php

abstract class Validator
{
	protected $_validators = array();

	public function acceptValidator(Validator $validator)
	{
		$this->_validators[] = $validator;
	}

	public function runValidation($element)
	{
		$subValidationResult = null;
		$propertyValidation = null;
		$objectValidation = null;

		$subValidationResult = $this->_validateAllSubValidators($element);
		if (false === $subValidationResult)
		{
			return false;
		}

		if (is_object($element))
		{
			$propertyValidation = $this->_validateProperties($element);
			if (false === $propertyValidation)
			{
				return false;
			}

			$objectValidation = $this->validate($element);
			if (false === $objectValidation)
			{
				return false;
			}
		}

		return ($subValidationResult || $propertyValidation || $objectValidation) ? true : null;
	}

	public function validate($element)
	{
		return null;
	}

	protected function _validateAllSubValidators($element)
	{
		$subValidatorValidation = null;

		if (!empty($this->_validators))
		{
			foreach ($this->_validators as $validator)
			{
				$resultOfSubValidator = $validator->runValidation($element);
				if (null === $resultOfSubValidator)
				{
					continue;
				}

				if (false === $resultOfSubValidator)
				{
					return false;
				}

				$subValidatorValidation = true;
			}
		}

		return $subValidatorValidation;
	}

	protected function _validateProperties($element)
	{
		$propertyValidation = null;

		$properties = get_object_vars($element);
		foreach ($properties as $name => $value)
		{
			if (is_object($value))
			{
				$resultOfPropertyValidation = $this->runValidation($value);
				if (null === $resultOfPropertyValidation)
				{
					continue;
				}

				if (false === $resultOfPropertyValidation)
				{
					return false;
				}

				$propertyValidation = true;
			}
		}

		return $propertyValidation;
	}

	public function __toString()
	{
		$composed_of_string = '';
		if (!empty($this->_validators))
		{
			$composed_of_string = ' composed of';
			foreach ($this->_validators as $validator)
			{
				$composed_of_string .= ' ' . $validator;
			}
		}

		return get_class($this) . $composed_of_string;
	}
} 