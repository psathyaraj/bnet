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
           $allowedDonorsBloodGroupArray =  RequestsRepository::$bloodTypeAndGroupArray[$this->bloodType][$this->bloodGroup];
           echo $this->bloodType."-".$this->bloodGroup;
           var_dump($allowedDonorsBloodGroupArray);
           echo "=======<br>";
            $em = $this->container->get("doctrine")->getManager();
            $qb = $em->createQueryBuilder();
            $qb->select('u.device_token' )
               ->from('AppBundle:Users', 'u')
               ->where('u.status != ?1')
               ->where()
               ->andWhere($qb->expr()->andX(
                             $qb->expr()->lte('u.dob', '?2'),
                             $qb->expr()->gte('u.dob', '?3')
                         ))
               ->andWhere('u.bloodGroup IN(?4)')
               ->setParameters(array(1 => 2,2 => date("Y-m-d",strtotime("-16 years")), 3 => date("Y-m-d",strtotime("-60 years")), 4 => $allowedDonorsBloodGroupArray))
              ;

            $query = $qb->getQuery();
            echo $query->getSql();
            echo $query->getParameters();
            $donorArray = $query->getArrayResult();
            return $donorArray;

    }

    public function sendPushNotification($bloodGroup, $bloodType){
        $this->bloodGroup = $bloodGroup;
        $this->bloodType = $bloodType;
        $donorsArray = $this->getDonors();
        $func = function($value) {
            return $value["device_token"];
        };

        $donorArray = array_map(function($value) {
                                      return $value["device_token"];
                                  }, $donorsArray);
        var_dump(join("\",\"",$donorArray));
        $url = "https://push.ionic.io/api/v1/push";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_HEADER, 1);
         curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
          curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type" => "application/json",
                "X-Ionic-Application-Id" => "2cc52b27",
                "Authorization" => "Basic NTA4MjM4ZmEwZTJkNTZjZWI4ZjUwNjM3NjA0ZjQwNjg0MWU3MDEwZTFhMmViN2I2Og=="
        ));

        $cmd='curl -u 508238fa0e2d56ceb8f50637604f406841e7010e1a2eb7b6: -H "Content-Type: application/json" -H "X-Ionic-Application-Id: 2cc52b27" https://push.ionic.io/api/v1/push -d \'{
                                "tokens":[
                                  '.'"'.join("\",\"",$donorArray).'"'.'
                                ],
                                "notification":{
                                  "alert":"Vitthal Malya Hospital",
                                  "android":{
                                  "sound":"donation",
                                  "title": "Donation Request",

                                    "payload":{
                                      "hospitalName":"Vitthal Malya Hospital",
                                      "hospitalLat":77,
                                      "hospitalLong":33,
                                      "dontationMessage":"Need a O- donor"
                                    }
                                  }
                                }
                              }\'';

                              echo $cmd;
        exec($cmd,$result);

        /*$body = '{
                  "tokens":[
                    "cD2IurFiAaU:APA91bHYm8BLJGnOqduBBnHt-Liikdc_8wH29UqnDHRuXwRkS6m7Meo8yX8PJgD_bOxmJmu7fP-qQEVOAUV4PgfyM_JNESTfmSGC5bdsE3hFFad0vEVm-u7tb5xE9fztW3yJKOvuTOg5"
                  ],
                  "notification":{
                    "alert":"Vitthal Malya Hospital",
                    "android":{
                    "sound":"donation",
                    "title": "Donation Request",

                      "payload":{
                        "hospitalName":"Vitthal Malya Hospital",
                        "hospitalLat":77,
                        "hospitalLong":33,
                        "dontationMessage":"Need a O- donor"
                      }
                    }
                  }
                }';
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);*/
        /*$message = new AndroidMessage();
        $message->setGCM(true);
        $message->setAllIdentifiers($donorArray);
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


        //$message->setAllIdentifiers(array("APA91bG9DUgSC9xg9po8LR3lxjYG42ikFAFrSTEx4HfDY4ZzPalBWDYRiZhwNPS-Iqp6MH83iBNhxzm4HKYqM_xuPekwfiSB0NpUAMnEMjXGy85HapiKBG-uPI0KMC_4Z6QnbAPJnrKjVcLIXllnLA_A51k73yawdw"));
        //$message->setMessage("Hello World");
        $this->container->get('rms_push_notifications')->send($message);*/
    }
}