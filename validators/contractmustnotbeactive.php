<?php

class ContractMustNotBeActive extends Validator
{
	public function validate($element)
	{
		if ($element instanceof Contract)
		{
			if (
				!empty($element->expirationDate)
				&& strtotime($element->expirationDate) > time()
			)
			{
				return false;
			}

			return true;
		}

		return parent::validate($element);
	}
} 