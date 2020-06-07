<?php namespace Wollson\Bokun\Components;

use Db;
use Carbon\Carbon;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Wollson\Bokun\Models\Bokun as Bokun;
use Note\Tours\Models\Tours;
use Note\Tours\Models\Styles;
use Note\Tours\Models\Destinations;
use Note\Tours\Models\Transportation;
use Illuminate\Support\Str; 
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use Martin\Forms\Classes\SendMail;
use Mail;
use Wollson\Bokun\Models\Bokun_auth;

class BokunCmp extends ComponentBase
{
    /**
     * @var Collection A collection of categories to display
     */
    public $bokun;
    private $tourid;
    private $bokun_name;
    private $phone;
    private $num_people;
    private $email;
    private $when;
    private $rent_date;
    private $hear_from;
    private $group_type;
    private $other;
    private $requests;
    private $rateid;
    private $pricingid;
    private $startid;
    private $tourprice = 0;
    private $payment;

    private $PP_CLIENT = "AW5z5mLE9bPOzeXz8bw9kQ4t5oMhTCB5MjIQCvXBfZ_z_bsRh-Nqn0QXulQpSJ-nVnq5cXYSnyTuWOp2";
    private $PP_SECRET = "ELdO9mtSBi6IwaHpTTbO4l3GOBhrfgH5YCJ5oUcWzvvUglIAcpH06qSbs4Ii_QbEOrY8j3EbTI0paVIV";
    private $destination; 
    //budapest default

    public function componentDetails()
    {
        return [
            'name'        => 'bokun',
        ];
    }

    public function onRun()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if(isset($_GET['type']) && $_GET['type'] == 'tours'){
            //echo 'tours';
            $bokun = new Bokun_auth('POST','/activity.json/search?currency=ISK&lang=EN');

            $data = $bokun->get_bokun_data();
            //var_dump($data);
            $this->updateTours($data);
            
        } 

        if (!isset($_GET['paymentId'])) {
            if(isset($this->page->components['Tour'])){
                $this->destination = $this->page->components['Tour']->tour->destinations[0]->attributes['title'];
                $this->setPrice((int)$this->page->components['Tour']->tour->attributes['price']);
            }
			
			$_SESSION['dest'][$_SERVER['REMOTE_ADDR']] = $this->destination; 
			
            $this->onBook();
        }
        else{
            $this->executePayment();
        }
    }

    public function processPayment($price,$peoples){
        $final = $price * (int)$peoples;

        return $final;
    }

    public function setPrice($price){
       $this->tourprice = $price; 
    }

    public function getPrice(){
        return $this->tourprice;
    }

    public function onBook(){
        if(isset($_GET['book_id']) || isset($_POST['book_id'])){
            if(isset($_GET['book_id'])) $this->tourid = $_GET['book_id'];
            if(isset($_POST['book_id'])) $this->tourid = $_POST['book_id'];

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $this->bokun_name = $_POST['name'];
            $this->phone = $_POST['phone'];
            $this->num_people = isset($_POST['num_people']) ? $_POST['num_people'] : 1;
            $this->email = $_POST['email'];
            if($_POST['when'] == ''){
                $this->when = date('Y-m-d',strtotime('+1 day'));
            }
            else{
                $this->when = date('Y-m-d',strtotime($_POST['when']));
            }
            $this->rent_date = isset($_POST['rent_date']) ? $_POST['rent_date'] : '10.00';
            //$this->hear_from = $_POST['hear_from'];
            $this->group_type = $_POST['group_type'];
            //$this->other = $_POST['other'];
            $this->requests = $_POST['requests'];
            $this->rateid = $_POST['rateid'];
            $this->pricingid = $_POST['pricingid'];
            $this->startid = $_POST['startid'];
            $this->tourprice = $_POST['price'];
			$this->payment = $_POST['payment'];
			
            
            $_SESSION[$_SERVER['REMOTE_ADDR']] = serialize($_POST);
          
            // //var_dump($_POST['payment']); 
            $redirect = '';
            if($_POST['payment'] == 'paypal'){

                $price = $this->processPayment($this->tourprice,$this->num_people);
                $redirect = $this->payNow($this->tourprice);
            }
            else{
                $response = $this->bookTourNow();
                $redirect = array('result'=>'/thank-you');
            }
            return $redirect;
        }  
    }



    public function onCancel(){
        $request = '{
          "note": "'.$_POST['note'].'",
          "notify": true,
          "refund": false
        }';

        $bokun = new Bokun_auth('POST','/booking.json/cancel-booking/'.$_POST['confirmationCode']);

        $resp = $bokun->get_bokun_data($request);

        return $resp->message;        
    }

    public function payNow($price){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
		$this->destination = $_SESSION['dest'][$_SERVER['REMOTE_ADDR']];

        //var_dump($this->destination);
				
            if($this->destination == 'Belgrade'){
                $this->PP_CLIENT = "AUUh1DSsklXaMDGHVgHDK9fDet_0jQyRCfzVqmlBnmoGRsoc_2L7L4Kcqu23XYLfJs58SqSMKbfxei6r";
                $this->PP_SECRET = "EL6heSl2wUr7TWT94HMZBw4b-0vn-zHN4ZkbY8bqJIr9yd4b0IaOSji_aecYqVtC8riSyYOjqVyT98ww";
                //$this->PP_CLIENT = "AWkVk6ZCHF8QV5_bhUvyIGGkG1bSbGUTtO1r4N48WOG0emA8Nfo6Qs0vi7e6MNxSCavVqNZRVZkHUTl4";
                //$this->PP_SECRET = "EE9RkiwV5xgX1Bf4b6mv0w4rJF3Qp-0cbrsIVr-FzKZLURWi7VQQqcP9s-ygcRKTXJY6GezFRQtXlZmR";
            }
            else{ //Budapest account
                $this->PP_CLIENT = "AW5z5mLE9bPOzeXz8bw9kQ4t5oMhTCB5MjIQCvXBfZ_z_bsRh-Nqn0QXulQpSJ-nVnq5cXYSnyTuWOp2";
                $this->PP_SECRET = "ELdO9mtSBi6IwaHpTTbO4l3GOBhrfgH5YCJ5oUcWzvvUglIAcpH06qSbs4Ii_QbEOrY8j3EbTI0paVIV";
                //$this->PP_CLIENT = "AWkVk6ZCHF8QV5_bhUvyIGGkG1bSbGUTtO1r4N48WOG0emA8Nfo6Qs0vi7e6MNxSCavVqNZRVZkHUTl4";
                //$this->PP_SECRET = "EE9RkiwV5xgX1Bf4b6mv0w4rJF3Qp-0cbrsIVr-FzKZLURWi7VQQqcP9s-ygcRKTXJY6GezFRQtXlZmR";
            }
			
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $this->PP_CLIENT,     // ClientID
                $this->PP_SECRET     // ClientSecret
            )
        );

        $apiContext->setConfig(
              array(
                'mode' => 'live',
              )
        );

        // After Step 2
        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new \PayPal\Api\Amount();
        $amount->setTotal($price);
        $amount->setCurrency('EUR');

        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription('You will pay ' . $price . ' EUR');

        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl("https://gowithnote.com/thank-you")
            ->setCancelUrl("https://gowithnote.com/tours");

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);
        
        // After Step 3
        $return = "";
        try {
            $payment->create($apiContext);

            $return = $payment->getApprovalLink(); 
        }
        catch (\PayPal\Exception\PayPalConnectionException $ex) {
            // This will print the detailed information on the exception.
            //REALLY HELPFUL FOR DEBUGGING
            $return = '/error';//$ex->getData();
        }

		
        return $return;
    }


    function bookTourNow(){
        //session_start();
        $status_paid = '';
        if($this->payment == 'paypal'){
            $status_paid = 'FULLY_PAID';
        }
        else{
            $status_paid = 'NOT_PAID';
        }
        $request = '{
        "activityRequest": {
            "activityId": '.$this->tourid.',
            "date":"'.$this->when.'",
            "startDate":"'.$this->when.'",
            "startTime": "'.$this->rent_date.'",
            "rateId": '.$this->rateid.',
            "startTimeId":'.$this->startid.',
            "pricingCategoryBookings": [';
            for ($i=1; $i <= $this->num_people; $i++) { 
                if($i == $this->num_people){
                    $request .= '{ "pricingCategoryId":'.$this->pricingid.' }';
                }
                else{
                    $request .= '{ "pricingCategoryId":'.$this->pricingid.' },';
                }
            }
        $request .=
           ']
        },
        "customer": {
            "email": "'.$this->email.'",
            "firstName": "'.$this->bokun_name.'",
            "phoneNumber": "'.$this->phone.'"       
        },
        "paymentOption": "' . $status_paid . '",
        "sendCustomerNotification": "true"
        }';


        $bokun = new Bokun_auth('POST','/booking.json/activity-booking/reserve-and-confirm');

        $response = $bokun->get_bokun_data($request);
        return $response;
    }

    public function executePayment(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $post = unserialize($_SESSION[$_SERVER['REMOTE_ADDR']]);
        
        $this->tourid = $post['tourid'];
        $this->bokun_name = $post['name'];
        $this->phone = $post['phone']; 
        $this->num_people = isset($post['num_people']) ? $post['num_people'] : 1;
        $this->email = $post['email'];
        if($post['when'] == ''){
            $this->when = date('Y-m-d');
        }
        else{
            $this->when = date('Y-m-d',strtotime($post['when']));
        }
        $this->rent_date = isset($post['rent_date']) ? $post['rent_date'] : '10.00';
        //$this->hear_from = $_POST['hear_from'];
        $this->group_type = $post['group_type'];
        //$this->other = $_POST['other'];
        $this->requests = $post['requests'];
        $this->rateid = $post['rateid'];
        $this->pricingid = $post['pricingid'];
        $this->startid = $post['startid'];
        $this->tourprice = $post['price'];
        $this->payment = $post['payment'];

        
        //var_dump($_POST);

        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $this->PP_CLIENT,     // ClientID
                $this->PP_SECRET     // ClientSecret
            )
        );
        $paymentId = $_GET['paymentId'];
        $payment = Payment::get($paymentId, $apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($_GET['PayerID']);

        try {
            $result = $payment->execute($execution, $apiContext);
            //var_dump($result);
            try {
                $payment = Payment::get($paymentId, $apiContext);
                $this->bookTourNow();
            } catch (Exception $ex) {
                header('Location: /error',true,301);
                //echo $ex;
            }
        } catch (Exception $ex) {
            header('Location: /error',true,301);
            //echo $ex;
        }
        session_unset();
        session_destroy();
        return $payment;
    }

    function bikesList(){
        $bokun = new Bokun_auth('GET','/car-rental.json/list');

        $response = $bokun->get_bokun_data($request);
        return $response;
    }

    public function testEmail(){
        // SEND NOTIFICATION EMAIL
        $vars = [];
        Mail::send('wollson.bokun::mail.tourpayed', $vars, function($message) {

            $message->from('office@wollson.rs', 'October');
            $message->to('srdjan.nezic@wollson.rs')->subject('Mail from site');

        });      
    }

    public function updateTours($data){
        ///var_dump($data->items);
        //var_dump($data);
        foreach($data->items as $item){

            $activity_id = $item->id;
            $bokun_extras = new Bokun_auth('GET','/activity.json/'.$item->id);
            $bokun_prices = new Bokun_auth('GET','/activity.json/'.$item->id.'/price-list?currency=EUR');
            $bokun_availabilities = new Bokun_auth('GET','/activity.json/'.$item->id.'/availabilities?start='.date('Y-m-d').'&end='.date('Y-m-d',strtotime("+7 day")));


            $bokun_prices_data = $bokun_prices->get_bokun_data();
            $bokun_availabilities_data = $bokun_availabilities->get_bokun_data();
            $bokun_extras = $bokun_extras->get_bokun_data();
            //var_dump($bokun_availabilities_data);
            //var_dump($bokun_extras);


            $privpub = array();
            var_dump($item->title);
            
            if(isset($bokun_prices_data->pricesByDateRange[0]->rates[0]->passengers[0]->price->amount)) {
                $rateId = $bokun_prices_data->pricesByDateRange[0]->rates[0]->rateId;
                $priceId = $bokun_prices_data->pricesByDateRange[0]->rates[0]->passengers;
                foreach($bokun_prices_data->pricesByDateRange[0]->rates[0]->passengers as $pas){
                    $privpub[] = $pas->title;
                }
                $amount = $bokun_prices_data->pricesByDateRange[0]->rates[0]->passengers[0]->price->amount;
                $currency = $bokun_prices_data->pricesByDateRange[0]->rates[0]->passengers[0]->price->currency;
            }
            else {
                $rateId = 0;
                $priceId = 0;
                $amount = 0;
                $currency = "€";
            }

            if($currency == 'EUR'){
                $currency = "€";
            }
            $num_people = 1;
            $startid = 0;
            $startids = array();
            if(isset($bokun_availabilities_data[0]->availabilityCount)){
                $num_people = $bokun_availabilities_data[0]->availabilityCount;
            }

            if(isset($bokun_availabilities_data[0]->startTimeId)){
                $startid = $bokun_availabilities_data[0]->startTimeId;
            }

            if(isset($bokun_availabilities_data[0]->rates[0]->startTimeIds)){
                $startids = $bokun_availabilities_data[0]->rates[0]->startTimeIds;
            }            
            
            //var_dump($bokun_availabilities_data[0]);
            $tours = new Tours;
            $is_update = $tours->checkIsTourExisting($item->title);
            if($is_update){
                $tours = Tours::find($is_update->id);
            }
            $points = array();
            foreach ($bokun_extras->startPoints as $point) {
                //var_dump($point);
                $points[] = $point->address->geoPoint;
            }

            //$points = json_encode($points);
           // $privpub = json_encode($privpub);

            //var_dump($privpub);

            var_dump($priceId);
        
            //var_dump($startids);
            $tours->title = $item->title;
            $tours->name = $item->title;
            $tours->summary = isset($item->excerpt) ? $item->excerpt : null;
            $tours->content = isset($item->summary) ? $item->summary : null;
            $tours->currency = $currency;
            $tours->price = $amount;
            //$tours->max_people = $num_people;
            $tours->bokun_activity_id = $activity_id;
            $tours->bokun_rate_id = $rateId;
            $tours->bokun_pricing_id = json_encode($priceId);
            $tours->bokun_start_id = $startid;
            $tours->bokun_start_ids = $startids;
            $tours->bokun_points = $points;
            $tours->group_type = $privpub;

            $cover = "";
            if(isset($item->keyPhoto)){
                $cover = $item->keyPhoto->originalUrl;
            }
            //var_dump($item->fields);
            $duration = 0;
            $days = 0;

            if(isset($item->fields->durationHours)){
                $value = "h";
                $duration = $item->fields->durationHours;
            }
            if($duration == 0){
                $value = "d";
                $duration = $item->fields->durationDays;

                $days = $item->fields->durationDays;
            }
            if(isset($item->fields->durationWeeks)) {
                if($item->fields->durationWeeks > 0){
                    $value = "d";
                    $duration = $item->fields->durationWeeks;
                    $days += ($item->fields->durationWeeks * 7);
                }
            }
            if($days > 0){
                $duration = $days;
                $value = 'd';
            }


            $tours->duration_value = $value;
            $tours->duration = $duration;

            $tours->bokun_media = $cover;

            
            if($is_update){
                echo "updated<br/>";
                $tours->update();
            }
            else{
                echo "saved<br/>";
                $tours->save();
            } 

            //update tour destination


            $country = '';
            foreach($item->locationCode as $key=>$loc){
                //destination
                
                $is_dest_update = false;

                
                if($key == 'country'){
                    $country = $loc;
                }

                if($key == 'name') {
                    $dest = new Destinations;
                    $is_dest_update = $dest->checkIsDestExisting($loc);
                    if($is_dest_update){  
                        $dest = Destinations::find($is_dest_update->id);  
                    }
                    $dest->title = $loc;
                    $dest->country = $country;
                    

                    if($is_dest_update){ 
                        $dest->update();
                        $hasTourDestination = $tours->destinations()->where('tour_id', $tours->id)->where('destination_id',$is_dest_update->id)->exists();
                        if(!$hasTourDestination){
                            $tours->destinations()->attach($tours->id,['destination_id'=>$is_dest_update->id]);
                        }
                        // end
                    }
                    else{
                        $dest->save(); //insert new destination
                        $hasTourDestination = $tours->destinations()->where('tour_id', $tours->id)->where('destination_id',$is_dest_update->id)->exists();
                        if(!$hasTourDestination){
                            $tours->destinations()->attach($tours->id,['destination_id'=>$dest->id]);
                        }
                        // end
                    }
                }

 
            }

            //update tour styles

            foreach($bokun_extras->bookableExtras as $extras){
                $styles = new Styles;
                $is_styles_update = $styles->where('name',$extras->title)->first();
                if($is_styles_update){
                    $styles = Styles::find($is_styles_update->id);
                }
                $styles->title = $extras->title;
                $styles->name = $extras->title;
                $styles->slug = Str::slug($extras->title);
                $styles->description = $extras->information; 

                if($is_styles_update){
                    $styles->update();
                    $hasTourStyle = $tours->style()->where('tour_id', $tours->id)->where('style_id',$is_styles_update->id)->exists();
                    if(!$hasTourStyle){
                        $tours->style()->attach($tours->id,['style_id'=>$is_styles_update->id]);
                    }

                }
                else{
                    $styles->save();
                    $hasTourStyle = $tours->style()->where('tour_id', $tours->id)->where('style_id',$is_styles_update->id)->exists();
                    if(!$hasTourStyle){
                        $tours->style()->attach($tours->id,['style_id'=>$styles->id]);
                    }
                }
            }

            //update tour transportation

            foreach($bokun_extras->flags as $flag){
                $trans = new Transportation;
                $is_trans_update = $trans->where('name',$flag)->first();
                if($is_trans_update){
                    $trans = Transportation::find($is_trans_update->id);
                }
                $trans->name = $flag;

                if($is_trans_update){
                    $trans->update();
                    if(isset($is_trans_update->id)){
                        $hasTourTrans = $tours->transportation()->where('tour_id', $tours->id)->where('transportation_id',$is_trans_update->id)->exists();
                        if(!$hasTourTrans){
                            $tours->transportation()->attach($tours->id,['transportation_id'=>$is_trans_update->id]);
                        }
                    }

                }
                else{
                    $trans->save();
                    if(isset($is_trans_update->id)){
                        $hasTourTrans = $tours->transportation()->where('tour_id', $tours->id)->where('transportation_id',$is_trans_update->id)->exists();
                        if(!$hasTourTrans){
                            $tours->transportation()->attach($tours->id,['transportation_id'=>$trans->id]);
                        }
                    }
                }                
            }

        }
        
    }
}
