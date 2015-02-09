<?php
/**
 * SendGrid Newsletter PHP API ...
 *
 * Copyright (C) 2011  Alon Ben David
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/gpl-3.0.txt>.
 *
 *
 * @author Alon Ben David - CoolGeex.com
 * 
 * All the methods returns an array of data or one string / int
 * If false returned you can run getLastResponseError() to see the error information
 * If error information == NULL then no error accrued (like deleting a record returns 0 records deleted if no record found)
 * 
 * CHECK sample.php for list of methods, variables and code samples
 * 
*/

class SG_NewsletterAPI {

	private $apiEndpoint;
	private $authUser;
	private $authKey;
	private $lastResponseError;

	/**
	 * Timeout in seconds for an API call to respond
	 * @var integer
	 */
	const TIMEOUT = 20;

	/**
	 *
	 * user agent ...
	 * @var string
	 */
	const USER_AGENT = 'Sendgrid Newsletter PHP API';

	/**
	 *
	 * sendgrid endpoint ...
	 * @var string
	 */
	const SG_ENDPOINT = 'https://sendgrid.com/api';

	/**
	 * Creates a new SendGrid Newsletter API object to make calls with
	 *
	 * Your API key needs to be generated using SendGrid Management
	 * Authentication is done automatically when making the first API call
	 * using this object.
	 *
	 * @param string $user The username of the account to use
	 * @param string $key The API key to use
	 */
	public function __construct($user, $key) {
		$this->authUser = $user;
		$this->authKey = $key;
		$this->apiEndpoint = self::SG_ENDPOINT;
	}

	/**
	 * Create a new Newsletter...
	 * @param string $identity - The Identity that will be used for the Newsletter being created.
 	 * @param string $name - The name that will be used for the Newsletter being created.
	 * @param string $subject - The subject that will be used for the Newsletter being created.
	 * @param string $text - The text portion of the Newsletter being created.
	 * @param string $html - The html portion of the Newsletter being created.
	 */
	public function newsletter_add($identity, $name = 'Newsletter Using API' , $subject , $text , $html) {
		$url = "newsletter/add";
		
		$postData = array(
			'identity'	=> $identity,
			'name'		=> $name,
		    'subject'   => $subject,
		    'text'      => $text,
			'html'      => $html,
		  );
		
		return $this->makeApiCall ( $url , $postData );
	}

	/**
	 * Edit an existing Newsletter...
	 * @param string $identity - The new Identity for the Newsletter being edited.
 	 * @param string $name	- The name of the Newsletter being updated.
	 * @param string $newname - The new name for the Newsletter being edited.
	 * @param string $subject -The new subject that will be used for the Newsletter being edited.
	 * @param string $text - The new text portion of the Newsletter being edited.
	 * @param string $html - The new html portion of the Newsletter being edited.
	 */
	public function newsletter_edit($identity, $name , $newname = 'Newsletter Using API' , $subject , $text , $html) {
		$url = "newsletter/edit";
		
		$postData = array(
			'identity'	=> $identity,
			'name'		=> $name,
			'newname'	=> $newname,
		    'subject'   => $subject,
		    'text'      => $text,
			'html'      => $html,
		  );
		
		return $this->makeApiCall ( $url , $postData );
	}


	/**
	 * Retrieve the content of an existing Newsletter.
 	 * @param string $name	- Must be an existing Newsletter
	 */
	public function newsletter_get($name) {
		$url = "newsletter/get";
		
		$postData = array(
			'name'	=> $name,
		  );
		
		return $this->makeApiCall ( $url , $postData );
	}

	/**
	 * Retrieve a list of all existing Newsletter.
 	 * @param string $name	- Can be an existing Newsletter
	 */
	public function newsletter_list($name = '') {
		$url = "newsletter/list";
		
		$postData = array(
			'name'	=> $name,
		  );
		
		return $this->makeApiCall ( $url , $postData );
	}
	
	/**
	 * Remove the Newsletter with this name..
 	 * @param string $name	- Must be an existing Newsletter
	 */
	public function newsletter_delete($name) {
		$url = "newsletter/delete";
		
		$postData = array(
			'name'	=> $name,
		  );
		
		return $this->makeApiCall ( $url , $postData );
	}
	
	/**
	 * Create a new Recipient List...
	 * @param string $list	- Create a Recipient List with this name.
 	 * @param string $name	- Specify the column name for the ‘name’ associated with email addresses..
	 */
	public function newsletter_lists_add($list , $name = '') {
		$url = "newsletter/lists/add";
		
		$postData = array(
			'list' => $list,
			'name'	=> $name,
		  );
		
		return $this->makeApiCall ( $url , $postData );
	}
	
	/**
	 * Create a new Recipient List...
	 * @param string $list	- This is the name of the Recipient List to be renamed..
 	 * @param string $newlist - Specify the new name for the Recipient List.
	 */
	public function newsletter_lists_edit($list , $newlist) {
		$url = "newsletter/lists/edit";
		
		$postData = array(
			'list' => $list,
			'newlist'	=> $newlist,
		  );
		
		return $this->makeApiCall ( $url , $postData );
	}
	
	/**
	 * Create a new Recipient List...
	 * @param string $list	- Check for this particular list. (To list all Recipient Lists on your account exclude this parameter)
	 */
	public function newsletter_lists_get($list = '') {
		$url = "newsletter/lists/get";
		
		$postData = array(
			'list' => $list,
		  );
		
		return $this->makeApiCall ( $url , $postData );
	}
	
	/**
	 * Remove this Recipient List....
	 * @param string $list	- Must be an existing Recipient List.
	 */
	public function newsletter_lists_delete($list) {
		$url = "newsletter/lists/delete";
		
		$postData = array(
			'list' => $list,
		  );
		
		return $this->makeApiCall ( $url , $postData );
	}
	
	/**
	 * Add an email to an existing Recipient List.
	 * @param string $list	- The list which you are adding email addresses too.
	 * @param array $data	- Specify the name, email address, and additional fields to add to the specified Recipient List..
	 *	EX: $data = array(
	 *				'email'	=>	'test1@test.com',
	 *				'name'	=>	'John Doe',
	 *			);
	 */
	public function newsletter_lists_email_add($list , $data) {
		$url = "newsletter/lists/email/add";
		
		$postData = array(
			'list' => $list,
			'data' => json_encode($data),
		  );

		$results = $this->makeApiCall ( $url , $postData );
		
		return (isset($results['inserted'])) ? $results['inserted'] : false;
	}
	
	
	/**
	 * Get the email addresses and associated fields for a Recipient List.
	 * @param string $list	- The list you are searching.
	 * @param string $email	- Optional email addresses to search for in the Recipient List.
	 */
	public function newsletter_lists_email_get($list , $email = '') {
		$url = "newsletter/lists/email/get";
		
		$postData = array(
			'list' => $list,
			'email' => $email,
		  );

		return $this->makeApiCall ( $url , $postData );
	}
	
	/**
	 * Remove one email from a Recipient List.
	 * @param string $list	- The list which you are removing email addresses from..
	 * @param string $email	- Specify the email address or email addresses you wish to remove from the specified Recipient List..
	 */
	public function newsletter_lists_email_delete($list , $email) {
		$url = "newsletter/lists/email/delete";
		
		$postData = array(
			'list' => $list,
			'email' => $email,
		  );

		$results = $this->makeApiCall ( $url , $postData );
		
		return (isset($results['removed'])) ? $results['removed'] : false;
	}
	
	/**
	 * Create a new Identity.
	 * @param string $identity	- Create an Identity named this.
	 * @param string $name	- Specify the name to be used for this Identity.
	 * @param string $email	- Specify the email address to be used for this Identity.
	 * @param string $address	- Create an Identity named this.
	 * @param string $city	- Specify the city to be used for this Identity.
	 * @param string $state	- Specify the state code to be used for this Identity.
	 * @param string $zip	- Specify the zip code to be used for this Identity.
	 * @param string $country	- Specify the country code to be used for this Identity.
	 */
	public function newsletter_identity_add($identity , $name , $email , $address , $city , $state , $zip , $country) {
		$url = "newsletter/identity/add";
		
		$postData = array(
			'identity' => $identity,
			'name' => $name,
			'email' => $email,
			'address' => $address,
			'city' => $city,
			'state' => $state,
			'zip' => $zip,
			'country' => $country,
		  );
		
		return $this->makeApiCall ( $url , $postData );
	}
	
	
	/**
	 * Edit an existing Identity..
	 * @param string $identity	- The Identity you wish to edit.
	 * @param string $newidentity	- Specify the new name to be used for this Identity.
	 * @param string $name	- Specify the name to be used for this Identity.
	 * @param string $email	- Specify the email address to be used for this Identity.
	 * @param string $address	- Create an Identity named this.
	 * @param string $city	- Specify the city to be used for this Identity.
	 * @param string $state	- Specify the state code to be used for this Identity.
	 * @param string $zip	- Specify the zip code to be used for this Identity.
	 * @param string $country	- Specify the country code to be used for this Identity.
	 */
	public function newsletter_identity_edit($identity , $newidentity , $name , $email , $address , $city , $state , $zip , $country) {
		$url = "newsletter/identity/edit";
		
		$postData = array(
			'identity' => $identity,
			'newidentity' => $newidentity,
			'name' => $name,
			'email' => $email,
			'address' => $address,
			'city' => $city,
			'state' => $state,
			'zip' => $zip,
			'country' => $country,
		  );
		
		return $this->makeApiCall ( $url , $postData );
	}
	
	/**
	 * Retrieve information associated with a particular Identity.
	 * @param string $identity	- Retrieve contents of the specified Identity.
	 */
	public function newsletter_identity_get($identity) {
		$url = "newsletter/identity/get";
		
		$postData = array(
			'identity' => $identity,
		  );
		
		return $this->makeApiCall ( $url , $postData );
	}
	
	/**
	 * List all Identities on your account, or check if a particular Identity exists.
	 * @param string $identity	- Check for this particular Identity. (To list all Identities on your account exclude this parameter)
	 */
	public function newsletter_identity_list($identity = '') {
		$url = "newsletter/identity/list";
		
		$postData = array(
			'identity' => $identity,
		  );
		
		return $this->makeApiCall ( $url , $postData );
	}
	
	/**
	 * Remove an Identity from your account.
	 * @param string $identity	- Remove the specified Identity from your account.
	 */
	public function newsletter_identity_delete($identity) {
		$url = "newsletter/identity/delete";
		
		$postData = array(
			'identity' => $identity,
		  );
		
		return $this->makeApiCall ( $url , $postData );
	}
	
	/**
	 * Add one or more Recipient List to a Newsletter.
	 * @param string $name	- This is the Newsletter to which you are adding Recipients Lists.
	 * @param string $name	- This is the Recipient List that will be added to the Newsletter
	 */
	public function newsletter_recipients_add($name , $list) {
		$url = "newsletter/recipients/add";
		
		$postData = array(
			'name' => $name,
			'list' => $list,
		  );
		
		return $this->makeApiCall ( $url , $postData );
	}
	
	/**
	 * Retrieve the Recipient Lists attached to an existing Newsletter.
	 * @param string $name	- Retrieve the Recipient Lists of an existing Newsletter.
	 */
	public function newsletter_recipients_get($name) {
		$url = "newsletter/recipients/get";
		
		$postData = array(
			'name' => $name,
		  );
		
		return $this->makeApiCall ( $url , $postData );
	}
	
	/**
	 * Add one or more Recipient List to a Newsletter.
	 * @param string $name	- Newsletter to remove Recipient Lists from.
	 * @param string $list	- Recipient Lists to remove.
	 */
	public function newsletter_recipients_delete($name , $list) {
		$url = "newsletter/recipients/delete";
		
		$postData = array(
			'name' => $name,
		  );
		
		return $this->makeApiCall ( $url , $postData );
	}
	
	/**
	 * Create a new schedule event.
	 * @param string $name	- Newsletter to schedule delivery for. (If Newsletter should be sent now, include no additional parameters.)
	 * @param string $at	- Date / Time to schedule newsletter Delivery.
	 *	Date / Time must be provided in ISO 8601 format (YYYY-MM-DD HH:MM:SS +-HH:MM)
	 * @param string $after	- Number of minutes until delivery should occur. Must be a positive integer.
	 */
	public function newsletter_schedule_add($name , $at ='' , $after ='') {
		$url = "newsletter/schedule/add";
		
		$postData = array(
			'name' => $name,
			'at' => $at,
			'after' => $after,
		  );
		
		return $this->makeApiCall ( $url , $postData );
	}
	
	/**
	 * Retrieve the scheduled delivery time for an existing Newsletter.
	 * @param string $name	- Retrieve the delivery time scheduled for this Newsletter.
	 */
	public function newsletter_schedule_get($name) {
		$url = "newsletter/schedule/get";
		
		$postData = array(
			'name' => $name,
		  );
		
		return $this->makeApiCall ( $url , $postData );
	}
	
	/**
	 * Cancel a scheduled send for a Newsletter.
	 * @param string $name	- Remove the scheduled delivery time from an existing Newsletter.
	 */
	public function newsletter_schedule_delete($name) {
		$url = "newsletter/schedule/delete";
		
		$postData = array(
			'name' => $name,
		  );
		
		return $this->makeApiCall ( $url , $postData );
	}
	
	/**
	 * Makes a call to an API
	 *
	 * @param string $url The relative URL to call (example: "/server")
	 * @param string $postData (Optional) The JSON string to send
	 * @param string $method (Optional) The HTTP method to use
	 * @return array The parsed response, or NULL if there was an error
	 */
	private function makeApiCall($url, $postData = NULL, $method = 'POST') {
		
		if(!$postData)return false;
		
		$postData['api_user'] = $this->authUser;
		$postData['api_key'] = $this->authKey;


		$url.= ".json";

		$jsonUrl = $this->apiEndpoint . '/' . $url;
		// Generate curl request
		$session = curl_init($jsonUrl);
		// Tell curl to use HTTP POST
		curl_setopt ( $session, CURLOPT_CUSTOMREQUEST, strtoupper ( $method ) );
		// Tell curl that this is the body of the POST
		curl_setopt ($session, CURLOPT_POSTFIELDS, $postData);
		// Tell curl not to return headers, but do return the response
		curl_setopt($session, CURLOPT_HEADER, false);
		curl_setopt ( $session, CURLOPT_USERAGENT, self::USER_AGENT );
		curl_setopt ( $session, CURLOPT_ENCODING, 'gzip,deflate' );
		curl_setopt ( $session, CURLOPT_TIMEOUT, self::TIMEOUT );
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

		// obtain response
		$jsonResponse = curl_exec($session);
		curl_close($session);

		$results  = json_decode ( $jsonResponse, TRUE );
		$this->lastResponseError = isset($results['error']) ? $results['error'] : NULL;

		return $this->lastResponseError ? false : $results;
	}
	
	public function getLastResponseError() {
		return $this->lastResponseError;
	}

}