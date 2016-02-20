<?php
namespace AppBundle\Services;

use RMS\PushNotificationsBundle\Message\AndroidMessage;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
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
            /*$allowedDonorsBloodGroupArray = Utils::$bloodTypeAndGroupArray[$this->$bloodType][$this->$bloodGroup];
            $qb = $em->createQueryBuilder();
            $qb->select('u.device_token' )
               ->from('Users', 'u')
               ->where('u.status != ?1')
               ->where('r.'.Utils::$bloodTypeAndGroupArray[$field].'
               ->where('u.dob => ?2 && u.dob <= ?3')
               ->where('u.blood_group in ?4');
            $query = $qb->getQuery();
            $array = $query->getArrayResult();*/

    }

    public function sendPushNotification($bloodGroup, $bloodType){
        $this->$bloodGroup = $bloodGroup;
        $this->$bloodType = $bloodType;
       // $donorsArray = $this->getDonors();
        $message = new AndroidMessage();
        $message->setGCM(true);
        //$message->setAllIdentifiers($donorsArray);
        $message->setData(array('sound'     => "donation",
                                                'soundname'     => "donation",
                                                'title'     => "Donation Request",
                                                'msgcnt' => 0,
                                                "collapseKey" => "applice",
                                                      "delayWhileIdle" => true,
                                                      "timeToLive" => "3",
                                                      "message" => "Hello World",
                                                "info" => array("hospitalName" => "Vittha Malya",
                                                "hospitalLat" => "34",
                                                "hospitalLong" => "34",
                                                "dontationMessage" => "Need O+ blood donor",)
                                                ));
        $message->setAllIdentifiers(array("APA91bG9DUgSC9xg9po8LR3lxjYG42ikFAFrSTEx4HfDY4ZzPalBWDYRiZhwNPS-Iqp6MH83iBNhxzm4HKYqM_xuPekwfiSB0NpUAMnEMjXGy85HapiKBG-uPI0KMC_4Z6QnbAPJnrKjVcLIXllnLA_A51k73yawdw"));
        //$message->setMessage("Hello World");
        $this->container->get('rms_push_notifications')->send($message);
    }
}