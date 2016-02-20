<?php
namespace AppBundle\Utils\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Aws\S3\S3Client;


class ValidationService
{
	private $container;
	private $em;
	
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->em = $container->get('doctrine')->getManager();
	}
	
	public function validateOperationHours($centers)
	{
		foreach($centers as $center){
			$operationHours = $center->getOperationHours();
			if(isset($operationHours) && $operationHours != ''){
				$day = -1;
				$index = 0;
				foreach($operationHours as $opHour){
					if($opHour->getOpDay() == $day){
						$newIndex = $opHour->getStartTimeIndex() + $opHour->getOffset();
						if($newIndex <= $index || $opHour->getStartTimeIndex() <= $index){
							throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, "Invalid time");
						}
						$index = $opHour->getStartTimeIndex() + ($opHour->getOffset()-1);
					}else{
						$day = $opHour->getOpDay();
						$index = $opHour->getStartTimeIndex() + ($opHour->getOffset()-1);
					}
				}
				return true;
			}
			throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, "Operation hours cannot be empty");		
		}
	}
}
