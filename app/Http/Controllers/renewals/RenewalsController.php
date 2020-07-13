<?php

namespace App\Http\Controllers\renewals;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RenewalsController extends Controller
{
    public function index(/*$associateid*/){
        
        $conection = \DB::connection('sqlsrv');
            $response = $conection->select("SELECT * FROM Renewal_Date WHERE Associateid = '873040400'");
        \DB::disconnect('sqlsrv');
        return view("renewals/index", compact('response'));
    }

    public function charge(Request $request){

        /*$billing = $request->billingContact;
        $cardNumber = $request->cardNumber;
        $securityCode = $request->securityCode;
        $expireMonth = $request->expireMonth;
        $expireYear = $request->expireYear;
        
        $fecha = date('Y-m-j');
        $nuevafecha = strtotime ( '+1 year' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j h:m:s' , $nuevafecha );*/
        
        $gateway = \Omnipay\Omnipay::create('Stripe');
        $gateway->setApiKey('sk_test_wUezIfP4G2EwM0YQoNdNqwYs00NrOnp5jd');

        $formData = array(
            'number' => '4242424242424242', //$cardNumber, 
            'expiryMonth' => '11', //$expireMonth, 
            'expiryYear' => '2022', //$expireYear, 
            'cvv' => '123', //$securityCode
        );

        $response = $gateway->purchase(
            array(
                'amount' => '79.00', 
                'currency' => 'USD', 
                'card' => $formData
            )
        )->send();

        if ($response->isRedirect()) {
            $response->redirect();
        }
        elseif ($response->isSuccessful()) {
            return 'isSuccessful';
        }
        else {
            echo 'Error: ' . $response->getMessage();
        }
    }
}
