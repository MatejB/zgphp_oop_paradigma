<?php

class NumberMustBeActive extends Validator
{
	public function validate($element)
	{
		if (!($element instanceof Number))
		{
			return parent::validate($element);
		}

		if (
			isset($element->active)
			&& false === $element->active
		)
		{
			return false;
		}

		return true;
	}
} 