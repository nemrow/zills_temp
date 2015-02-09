<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('Includes/emailTemplates.php');
require_once('Includes/RequestHandlerBase.php');

class FeedBackHandler extends RequestHandlerBase {

    private $email;
    private $category;
    private $content;
    private $userAgent;

    public function auth() {
        return true;
    }

    public function validateAndLoadData($data) {  // todo validate if account/sale/etc already exists
        $this->email = $data['email'];
        $this->category = $data['category'];
        $this->content = $data['content'];
        $this->userAgent = $data['userAgent'];
        return true;
    }

    public function process() {
        $emailTemplate = new emailTemplates;
        try{
        $emailTemplate->sendSingleEmail('nemrowj@gmail.com', 'staff@zillionears.com', 'Feedback', 'Feedback', $this->category, $this->content.'<br><br>User Agent: '.$this->userAgent, $this->email);
            return 'success';
        }  catch (Exception $e){
            return 'fail';
        }
    }

}

?>