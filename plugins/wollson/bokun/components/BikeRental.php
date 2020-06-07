<?php namespace Wollson\Bokun\Components;

use Db;
use Carbon\Carbon;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Wollson\Bokun\Models\Bokun as Bokun;
use Note\Tours\Models\Tours;
use Note\Tours\Models\Destinations;
use Wollson\Bokun\Models\Bokun_auth as BokunAuth;


class BikeRental extends ComponentBase
{
    /**
     * @var Collection A collection of categories to display
     */
    private $bikeid;

    public function componentDetails()
    {
        return [
            'name'        => 'BikeRentalForm',
        ];
    }

    public function onRun()
    {
        $this->page['vehicles'] = $this->bikesList();
    }

    public function onRentBike(){
        if(isset($_GET['bikeid']) || isset($_POST['bikeid'])){

            $this->bikeid = $_POST['bikeid'];

            $response = $this->rentBikeNow();
            echo json_encode($response);
        }         
    }

    function rentBikeNow(){
        $request = '{
  "carRentalRequest": {
    "carRentalId": 518,
    "cars": [
      {
        "carTypeId": 1457,
        "unitCount": 1
      }
    ],
    "dropoffDate": "2019-06-25",
    "dropoffLocationId": 709,
    "pickupDate": "2019-06-26",
    "pickupLocationId": 709,
    "startDate": "2019-06-25",
    "endDate": "2019-06-25"
  },
  "customer": {
    "address": "string",
    "contactDetailsHidden": true,
    "contactDetailsHiddenUntil": "2019-06-25T09:25:43.644Z",
    "country": "string",
    "created": "2019-06-25T09:25:43.644Z",
    "credentials": {
      "username": "string"
    },
    "dateOfBirth": "2019-06-25T09:25:43.644Z",
    "email": "string",
    "firstName": "string",
    "id": 0,
    "language": "string",
    "lastName": "string",
    "nationality": "string",
    "organization": "string",
    "passportExpMonth": "string",
    "passportExpYear": "string",
    "passportId": "string",
    "phoneNumber": "string",
    "phoneNumberCountryCode": "string",
    "place": "string",
    "postCode": "string",
    "sex": "string",
    "state": "string",
  },
  "paymentOption": "NOT_PAID"
}';

        $bokun = new BokunAuth('POST','/booking.json/car-rental-booking/reserve-and-confirm');

        $response = $bokun->get_bokun_data($request);
        return $response;
    }

    function bikesList(){
        $bokun = new BokunAuth('GET','/car-rental.json/list');

        $response = $bokun->get_bokun_data();
        $response = json_decode(json_encode($response), true);
        //var_dump($response);
        return $response;
    }
}
