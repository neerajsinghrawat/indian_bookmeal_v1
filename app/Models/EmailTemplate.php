<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mail;
use App\Models\EmailTemplate;
use App\Models\Setting;

class EmailTemplate extends Model
{
    protected $table = 'email_templates';
 
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['email_templates'];



    public function replaceEmailContent($postData, $emailContent,$extraContentArr = NULL){
        
        $username  = isset($postData['username']) ? $postData['username'] : '';
        $fname  = isset($postData['first_name']) ? $postData['first_name'] : '';
        $lname  = isset($postData['last_name']) ? $postData['last_name'] : '';
        $email  = isset($postData['email']) ? $postData['email'] : '';
        $phone  = isset($postData['phone']) ? $postData['phone'] : '';
        $password  = isset($postData['password']) ? $postData['password'] : '';
        $address  = isset($postData['address']) ? $postData['address'] : '';
        $postcode  = isset($postData['postcode']) ? $postData['postcode'] : '';


        $user_ordersummary ='';
        $user_tablesummary ='';
        if (isset($extraContentArr) && !empty($extraContentArr)) {

            $user_ordersummary  = isset($extraContentArr['Ordersummary']) ? $extraContentArr['Ordersummary'] : '';
            $user_tablesummary  = isset($extraContentArr['Tablesummary']) ? $extraContentArr['Tablesummary'] : '';
        }
      
       $data = str_replace(array('#CUSTOMER_USERNAME','#CUSTOMER_FNAME','#CUSTOMER_LNAME','#CUSTOMER_EMAIL','#CUSTOMER_PHONE','#CUSTOMER_PASSWORD','#CUSTOMER_ADDRESS','#CUSTOMER_POSTCODE','#CUSTOMER_ORDER_SUMMARY','#CUSTOMER_TABLE_RESERVATIONS'), array($username,$fname,$lname,$email,$phone,$password,$address,$postcode,$user_ordersummary,$user_tablesummary),$emailContent);
        
        return $data;
    }
    
    
    public function sendAdminEmail($postData, $email_template_id){

        $emailTemplate = new EmailTemplate;
        $setting = Setting::first();
        //pr($extraContentArr);die('tgdhyvfgcv');
        $email_templates = EmailTemplate::where('status','=', 1)->where('id','=', $email_template_id)->first();
        
        if(!empty($email_templates)){
                    //$url = Configure::read('root_url');
                    $emailContent = $emailTemplate->replaceEmailContent($postData, $email_templates->message);
                     //echo '<pre>';print_r($emailContent);die;
                                      Mail::send('emails.template',array('emailContent' => $emailContent,'setting' => $setting,'email_templates' => $email_templates,),function($message) use (&$setting,$email_templates){

                                        $message->to('rawat.neeraj.510@gmail.com','test')->subject($email_templates['subject']);
                                        $message->from($setting['email'],$setting['site_title']);
                                    });


                }
                
        
    }

    public function sendUserEmail($postData, $email_template_id, $extraContentArr = null){

        $emailTemplate = new EmailTemplate;
        $setting = Setting::first();
        //echo '<pre>';pr($extraContentArr);die('tgdhyvfgcv');
        $email_templates = EmailTemplate::where('status','=', 1)->where('id','=', $email_template_id)->first();
        
        if(!empty($email_templates)){
            //$url = Configure::read('root_url');
            $emailContent = $emailTemplate->replaceEmailContent($postData, $email_templates->message,$extraContentArr);
             //echo '<pre>';print_r($emailContent);die;
                              Mail::send('emails.template',array('emailContent' => $emailContent,'setting' => $setting,'email_templates' => $email_templates,),function($message) use (&$setting,$email_templates,$postData){

                                $message->to($postData['email'])->subject($email_templates['subject']);
                                $message->from($setting['email'],$setting['site_title']);
                            });
        }
    }
     
}
