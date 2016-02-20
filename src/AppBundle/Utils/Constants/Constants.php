<?php
namespace AppBundle\Utils\Constants;

Class Constants
{	
    const GENDER_FEMALE = 0;
    const GENDER_MALE = 1;
    const GENDER_UNISEX= 2;
	
	const SLOT_OPEN = 1;
	const SLOT_BOOKED = 2;
	const SLOT_BREAK = 3;
	const SLOT_OFFER = 4;
	
	public static $genderMap = array(
			self::GENDER_FEMALE => 'Female',
			self::GENDER_MALE => 'Male',
			self::GENDER_UNISEX => 'Unisex'
	);
	
}