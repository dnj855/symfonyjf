<?php
/**
 * User: cedriclangroth
 * Date: 31/07/2018
 * Time: 14:49
 */

namespace ServiceJF\CoreBundle\SMS;


use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SMSInterface
{
    private $device;
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->device = $this->container->getParameter('sms_device');
    }

    public function apiInterface($data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://smsgateway.me/api/v4/message/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTUzNDg4ODA3OSwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjU5NTMzLCJyb2xlcyI6WyJST0xFX1VTRVIiXX0._TUHXdKHfG97HxHhCqCDKvGMY5vaCLxungZA-9ZWegM",
                "Cache-Control: no-cache",
                "Content-Type: application/json",
                "Postman-Token: 91c8355a-eba6-4ed2-a78d-91240012313b"
            ),
            CURLOPT_POSTFIELDS => json_encode($data)
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        return $response;
    }

    public function sendSMS($receivers, $message)
    {
        foreach ($receivers as $receiver) {
            if (!preg_match('/^\+33[6-7][0-9]{8}$/', $receiver)) {
                throw new Exception('Le numéro envoyé n\'est pas valide !');
            }
        }
        foreach ($receivers as $receiver) {
            $data[] = array(
                "phone_number" => $receiver,
                "message" => $message,
                "device_id" => $this->device
            );
        }
        $resultPostJob = $this->apiInterface($data);
        return $resultPostJob;
    }

    public function getPhoneNumbers($users)
    {
        foreach ($users as $user) {
            if ($user->getPhoneNumber() == null || $user->getVerifiedNumber() == false) {
            } else {
                $phoneNumbers[] = $user->getPhoneNumber();
            }
        }
        return $phoneNumbers;
    }
}