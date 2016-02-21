<?php
namespace AppBundle\Services;

use RMS\PushNotificationsBundle\Message\AndroidMessage;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use AppBundle\Repository\RequestsRepository;
use AppBundle\Repository\UsersRepository;

class RequestDonors
{
    private $bloodGroup;
    private $bloodType;
    private $container;
    public function __construct(
            Container $container
        ) {
            $this->container = $container;

        }
    public function getDonors(){
    	$bgroup = $this->bloodGroup!='' && $this->bloodGroup?$this->bloodGroup:1;
           $allowedDonorsBloodGroupArray =  RequestsRepository::$bloodTypeAndGroupArray[$this->bloodType][$bgroup];
          
            $em = $this->container->get("doctrine")->getManager();
            $qb = $em->createQueryBuilder();
            $qb->select('u.device_token' )
               ->from('AppBundle:Users', 'u')
               ->where('u.status != ?1')
               ->andWhere($qb->expr()->andX(
                             $qb->expr()->lte('u.dob', '?2'),
                             $qb->expr()->gte('u.dob', '?3')
                         ))
               ->andWhere('u.bloodGroup IN(?4)')
               ->setParameters(array(1 => 2,2 => date("Y-m-d",strtotime("-16 years")), 3 => date("Y-m-d",strtotime("-60 years")), 4 => $allowedDonorsBloodGroupArray))
              ;

            $query = $qb->getQuery();
            $donorArray = $query->getArrayResult();
            return $donorArray;

    }

    public function sendPushNotification($requests){
    	$hospital = $requests->getHospital();
    	
        $this->bloodGroup = $requests->getBloodGroup();
        $this->bloodType = $requests->getType();
        $donorsArray = $this->getDonors();
        $func = function($value) {
            return $value["device_token"];
        };

        $donorArray = array_map(function($value) {
                                      return $value["device_token"];
                                  }, $donorsArray);
        $bgroup = $this->bloodGroup!='' && $this->bloodGroup?RequestsRepository::$bloodGroupNameArray[$this->bloodGroup]:'Any';
        
        $message = "Need a ".$bgroup.' Group for '.RequestsRepository::$bloodTypeNameArray[$this->bloodType] .' at '.$hospital->getName();

        $cmd='curl -u 508238fa0e2d56ceb8f50637604f406841e7010e1a2eb7b6: -H "Content-Type: application/json" -H "X-Ionic-Application-Id: 2cc52b27" https://push.ionic.io/api/v1/push -d \'{
                                "tokens":[
                                  '.'"'.join("\",\"",$donorArray).'"'.'
                                ],
                                "notification":{
                                  "alert":"'.$hospital->getName().'",
                                  "android":{
                                  "message":"'.$message.'",
                                  "sound":"donation",
                                  "title": "Donation Request",

                                    "payload":{
                                      "hospitalName":"'.$hospital->getName().'",
                                      "hospitalLat":"'.$hospital->getLatitude().'",
                                      "hospitalLong":"'.$hospital->getLongitude().'",
                                      "request_id":"'.$requests->getId().'",
                                      "bloodGroup":"'.$bgroup.'",
                                      "type":"'.RequestsRepository::$bloodTypeNameArray[$this->bloodType] .'",
                                      "dontationMessage":"'.$message.'"
                                    }
                                  }
                                }
                              }\'';
        
        exec($cmd,$result);
       
    }
}