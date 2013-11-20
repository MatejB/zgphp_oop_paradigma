<?php

die('for reading only');

$service = new Service();
$response = $service->someMethod();

// opcija 1
if ($response == null)
{
	$error_details = $service->getErrorDetails();
}

// opcija 2
if ($response->inError)
{
	$error_details = $response;
}

// opcija 3
$validator = new Validator();
if (!$validator->isValid($response))
{
	$error_details = $validator->errorDetails();
}

// opcija 4
$validator = new Validator();
$validator->setVailidationTest($validationTest);
if (!$validator->isValid($response))
{
	$error_details = $validator->errorDetails();
}

// opcija 5
$validator = new Validator();
$validator->setVailidationTest($service);
if (!$validator->isValid($response))
{
	$error_details = $validator->errorDetails();
}

/***********************************/

// opcija 6
$dynamic_element_model = Factory::create('ElementModelType1')
	->augment(Factory::create('ElementModelType2')
		->augment(Factory::create('ElementModelType3'))
		->augment(Factory::create('ElementModelType4'))
	)
	->augment(Factory::create('ElementModelType3'));

$operation_on_elements = Factory::create('OperationType1');

$dynamic_validation_of_operation = Factory::create('ValidationType1')
	->augment(Factory::create('ValidationType2'))
	->augment(Factory::create('ValidationType3')
			->augment(Factory::create('ValidationType4'))
			->augment(Factory::create('ValidationType5'))
	);

$operation_on_elements->validateUsing($dynamic_validation_of_operation);

$result = $dynamic_element_model->operation($dynamic_operation);