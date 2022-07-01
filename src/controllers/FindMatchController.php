<?php
require_once 'AppController.php';
require_once __DIR__ .'/../models/Schedule.php';
require_once __DIR__.'/../repository/FindMatchRepository.php';

class FindMatchController extends AppController{

    private $message = [];
    private $findMatchRepository;

    public function __construct(){
        parent::__construct();
        $this->findMatchRepository = new FindMatchRepository();
    }

    public function find_match(){
        return $this->render('find_match');
    }

    public function get_match(){

        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));

            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            $location = $this->geocode($decoded['location']);
            $lat = $location[0];
            $lon = $location[1];

            echo json_encode($this->findMatchRepository->findMatch($lat,$lon,$decoded['zakres']));

        }
    }

    function geocode($address){

        // url encode the address
        $address = urlencode($address);

        // google map geocode api url
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyB4DoB4ybtvUV2OwUNEKgqYuw5cdA_vYpE";

        // get the json response
        $resp_json = file_get_contents($url);

        // decode the json
        $resp = json_decode($resp_json, true);
        // response status will be 'OK', if able to geocode given address
        if($resp['status']=='OK'){

            // get the important data
            $lati = $resp['results'][0]['geometry']['location']['lat'] ?? "";
            $longi = $resp['results'][0]['geometry']['location']['lng'] ?? "";
            $formatted_address = $resp['results'][0]['formatted_address'] ?? "";

            // verify if data is complete
            if($lati && $longi && $formatted_address){

                // put the data in the array
                $data_arr = array();

                array_push(
                    $data_arr,
                    $lati,
                    $longi,
                    $formatted_address
                );

                return $data_arr;

            }else{
                return false;
            }

        }
        else{
            echo "<strong>ERROR: {$resp['status']}</strong>";
            return false;
        }
    }

}