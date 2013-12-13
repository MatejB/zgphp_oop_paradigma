<?php

date_default_timezone_set('Europe/Zagreb');

set_include_path(
	get_include_path()
	. PATH_SEPARATOR . 'elements/'
	. PATH_SEPARATOR . 'operations/'
	. PATH_SEPARATOR . 'validators/'
);
spl_autoload_register();


/*

dva broja
	od kojih su neki u isključenju

$operacija
	pošalji sms koristeći broj X na broj Y

$rezultat
	nije moguće zato jer je broj X u isključenju

*/

$brojA = new Number();
$brojA->id = 1;
$brojA->number = 2648779;
$brojA->active = false;

$brojB = new Number();
$brojB->id = 2;
$brojB->number = 48977977;

$sms = new SmsOperation($brojA, $brojB);
$sms->acceptValidator(new NumberMustBeActive());
if ($sms->validOperation())
{
	$sms->execute();
}

/* -------------------------- */



/*

tarifa
grupa brojeva
		od kojih su neki pod ugovorom
			na X mjeseci
		od kojih su neki u isključenju

$operacija
	aktiviraj tarifu nad grupom brojeva

$rezultat
	aktivirana usluga svima kojima može biti

*/


$numbers = array();
$numbers[] = new Number(array(
		'id' => 1,
		'number' => 56498797,
		'contract' => new Contract(array(
			'expirationDate' => '12.12.2013.'
		))
	));
$numbers[] = new Number(array(
		'id' => 2,
		'number' => 54877796,
		'contract' => new Contract(array(
			'expirationDate' => '12.01.2013.'
	   	)),
		'connected_number' => new Number(array(
			'id' => 101,
			'contract' => new Contract(array(
				'expirationDate' => '12.12.2013.'
			))
		))
	));
$numbers[] = new Number(array(
		'id' => 3,
		'number' => 135646779,
		'active' => false
	));

$tariff = new Tariff('TARIFF-A-XA');

$tariffChangeOperation = new TariffChangeOperation($tariff, $numbers);

//$numberMustBeActive = new NumberMustBeActive();
//$numberMustBeActive->acceptValidator(new ContractMustNotBeActive());
//$tariffChangeOperation->acceptValidator($numberMustBeActive);

$dynamicValidator = new DynamicValidator();
$dynamicValidator->acceptValidator(new NumberMustBeActive());
$dynamicValidator->acceptValidator(new ContractMustNotBeActive());
$tariffChangeOperation->acceptValidator($dynamicValidator);

if ($tariffChangeOperation->validOperation())
{
	$tariffChangeOperation->execute();
}

/* -------------------------- */
