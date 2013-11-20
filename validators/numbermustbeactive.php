<?php

class NumberMustBeActive extends Validator
{
	public function validate($element)
	{
		if ($element instanceof Number)
		{
			if (
				isset($element->active)
				&& false === $element->active
			)
			{
				return false;
			}

			return true;
		}

		return parent::validate($element);
	}
} 