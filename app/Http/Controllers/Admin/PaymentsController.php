<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use URL;
use Session;
use Redirect;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;



class PaymentsController extends Controller
{
    private $_api_context;
    public function __construct()
    {
        $this->middleware('auth:admin');
	   /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        //echo '<pre>';print_r();die;
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );

        //
        $this->_api_context->setConfig($paypal_conf['settings']);
        //echo '<pre>';print_r($paypal_conf['settings']));die;
	}


/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */
    public function pay()
    {
   
    return view('admin.payments.pay');
        
    }


/**
 * Show the form for creating a new resource.
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function paypal(Request $request)
    {
         //die('dssdfsdf');
        //dd($request->get('amount'));exit;
    $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName('Item 1') /** item name **/
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($request->get('amount')); /** unit price **/
           //echo '<prE>item_1'; print_r($item_1); die;          
            $item_list = new ItemList();
        $item_list->setItems(array($item_1));
//echo '<prE>item_1'; print_r($item_list); die; 
        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($request->get('amount'));
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('12_23');
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::to('admin/payments/success')) /** Specify return URL **/
            ->setCancelUrl(URL::to('admin/products/cancel'));


        $patchReplace = new Patch();
        $patchReplace->setOp('add')
                    ->setPath('/transactions/0/item_list/shipping_address')
                    ->setValue(json_decode('{
                        "line1": "345 Lark Ave",
                        "city": "Montreal",
                        "state": "QC",
                        "postal_code": "H1A4K2",
                        "country_code": "CA"
                    }'));

        $patchRequest = (new PatchRequest())->setPatches([$patchReplace]);

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
            //->setPatchRequests(array($patchRequest));

       //echo '<pre>item_list'; print_r($payment); die;

/*
        try{

            $payment->create($this->_api_context);
            $payment->update($patchRequest, $this->_api_context);*/
   
        try {
           
            $payment->create($this->_api_context);
            $payment->update($patchRequest, $this->_api_context);
              //dd($payment);exit;
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                \Session::put('error', 'Connection timeout');
                return Redirect::to('/');
            } else {
                \Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::to('/');
            }
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        \Session::put('error', 'Unknown error occurred');
        return Redirect::to('/');
    }



    public function getPaymentStatus()
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            \Session::put('error', 'Payment failed');
            return Redirect::to('/');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
         dd($result);exit;
        if ($result->getState() == 'approved') {
            \Session::put('success', 'Payment success');
            return Redirect::to('/');
        }
        \Session::put('error', 'Payment failed');
        return Redirect::to('/');
    }


}
