<?php
/** 
 *  PHP Version 5
 *
 *  @category    Amazon
 *  @package     Amazon_FPS
 *  @copyright   Copyright 2008-2009 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *  @link        http://aws.amazon.com
 *  @license     http://aws.amazon.com/apache2.0  Apache License, Version 2.0
 *  @version     2010-08-28
 */
/******************************************************************************* 
 *    __  _    _  ___ 
 *   (  )( \/\/ )/ __)
 *   /__\ \    / \__ \
 *  (_)(_) \/\/  (___/
 * 
 *  Amazon FPS PHP5 Library
 *  Generated: Wed Jun 15 05:50:14 GMT+00:00 2011
 * 
 */

/**
 *  @see Amazon_FPS_Model
 */
require_once ('Amazon/FPS/Model.php');  

    

/**
 * Amazon_FPS_Model_GetAccountActivityRequest
 * 
 * Properties:
 * <ul>
 * 
 * <li>MaxBatchSize: int</li>
 * <li>StartDate: string</li>
 * <li>EndDate: string</li>
 * <li>SortOrderByDate: SortOrder</li>
 * <li>FPSOperation: FPSOperation</li>
 * <li>PaymentMethod: PaymentMethod</li>
 * <li>Role: TransactionalRole</li>
 * <li>TransactionStatus: TransactionStatus</li>
 *
 * </ul>
 */ 
class Amazon_FPS_Model_GetAccountActivityRequest extends Amazon_FPS_Model
{


    /**
     * Construct new Amazon_FPS_Model_GetAccountActivityRequest
     * 
     * @param mixed $data DOMElement or Associative Array to construct from. 
     * 
     * Valid properties:
     * <ul>
     * 
     * <li>MaxBatchSize: int</li>
     * <li>StartDate: string</li>
     * <li>EndDate: string</li>
     * <li>SortOrderByDate: SortOrder</li>
     * <li>FPSOperation: FPSOperation</li>
     * <li>PaymentMethod: PaymentMethod</li>
     * <li>Role: TransactionalRole</li>
     * <li>TransactionStatus: TransactionStatus</li>
     *
     * </ul>
     */
    public function __construct($data = null)
    {
        $this->_fields = array (
        'MaxBatchSize' => array('FieldValue' => null, 'FieldType' => 'int'),
        'StartDate' => array('FieldValue' => null, 'FieldType' => 'string'),
        'EndDate' => array('FieldValue' => null, 'FieldType' => 'string'),
        'SortOrderByDate' => array('FieldValue' => null, 'FieldType' => 'SortOrder'),
        'FPSOperation' => array('FieldValue' => null, 'FieldType' => 'FPSOperation'),
        'PaymentMethod' => array('FieldValue' => null, 'FieldType' => 'PaymentMethod'),
        'Role' => array('FieldValue' => array(), 'FieldType' => array('TransactionalRole')),
        'TransactionStatus' => array('FieldValue' => null, 'FieldType' => 'TransactionStatus'),
        );
        parent::__construct($data);
    }

        /**
     * Gets the value of the MaxBatchSize property.
     * 
     * @return int MaxBatchSize
     */
    public function getMaxBatchSize() 
    {
        return $this->_fields['MaxBatchSize']['FieldValue'];
    }

    /**
     * Sets the value of the MaxBatchSize property.
     * 
     * @param int MaxBatchSize
     * @return this instance
     */
    public function setMaxBatchSize($value) 
    {
        $this->_fields['MaxBatchSize']['FieldValue'] = $value;
        return $this;
    }

    /**
     * Sets the value of the MaxBatchSize and returns this instance
     * 
     * @param int $value MaxBatchSize
     * @return Amazon_FPS_Model_GetAccountActivityRequest instance
     */
    public function withMaxBatchSize($value)
    {
        $this->setMaxBatchSize($value);
        return $this;
    }


    /**
     * Checks if MaxBatchSize is set
     * 
     * @return bool true if MaxBatchSize  is set
     */
    public function isSetMaxBatchSize()
    {
        return !is_null($this->_fields['MaxBatchSize']['FieldValue']);
    }

    /**
     * Gets the value of the StartDate property.
     * 
     * @return string StartDate
     */
    public function getStartDate() 
    {
        return $this->_fields['StartDate']['FieldValue'];
    }

    /**
     * Sets the value of the StartDate property.
     * 
     * @param string StartDate
     * @return this instance
     */
    public function setStartDate($value) 
    {
        $this->_fields['StartDate']['FieldValue'] = $value;
        return $this;
    }

    /**
     * Sets the value of the StartDate and returns this instance
     * 
     * @param string $value StartDate
     * @return Amazon_FPS_Model_GetAccountActivityRequest instance
     */
    public function withStartDate($value)
    {
        $this->setStartDate($value);
        return $this;
    }


    /**
     * Checks if StartDate is set
     * 
     * @return bool true if StartDate  is set
     */
    public function isSetStartDate()
    {
        return !is_null($this->_fields['StartDate']['FieldValue']);
    }

    /**
     * Gets the value of the EndDate property.
     * 
     * @return string EndDate
     */
    public function getEndDate() 
    {
        return $this->_fields['EndDate']['FieldValue'];
    }

    /**
     * Sets the value of the EndDate property.
     * 
     * @param string EndDate
     * @return this instance
     */
    public function setEndDate($value) 
    {
        $this->_fields['EndDate']['FieldValue'] = $value;
        return $this;
    }

    /**
     * Sets the value of the EndDate and returns this instance
     * 
     * @param string $value EndDate
     * @return Amazon_FPS_Model_GetAccountActivityRequest instance
     */
    public function withEndDate($value)
    {
        $this->setEndDate($value);
        return $this;
    }


    /**
     * Checks if EndDate is set
     * 
     * @return bool true if EndDate  is set
     */
    public function isSetEndDate()
    {
        return !is_null($this->_fields['EndDate']['FieldValue']);
    }

    /**
     * Gets the value of the SortOrderByDate property.
     * 
     * @return SortOrder SortOrderByDate
     */
    public function getSortOrderByDate() 
    {
        return $this->_fields['SortOrderByDate']['FieldValue'];
    }

    /**
     * Sets the value of the SortOrderByDate property.
     * 
     * @param SortOrder SortOrderByDate
     * @return this instance
     */
    public function setSortOrderByDate($value) 
    {
        $this->_fields['SortOrderByDate']['FieldValue'] = $value;
        return $this;
    }

    /**
     * Sets the value of the SortOrderByDate and returns this instance
     * 
     * @param SortOrder $value SortOrderByDate
     * @return Amazon_FPS_Model_GetAccountActivityRequest instance
     */
    public function withSortOrderByDate($value)
    {
        $this->setSortOrderByDate($value);
        return $this;
    }


    /**
     * Checks if SortOrderByDate is set
     * 
     * @return bool true if SortOrderByDate  is set
     */
    public function isSetSortOrderByDate()
    {
        return !is_null($this->_fields['SortOrderByDate']['FieldValue']);
    }

    /**
     * Gets the value of the FPSOperation property.
     * 
     * @return FPSOperation FPSOperation
     */
    public function getFPSOperation() 
    {
        return $this->_fields['FPSOperation']['FieldValue'];
    }

    /**
     * Sets the value of the FPSOperation property.
     * 
     * @param FPSOperation FPSOperation
     * @return this instance
     */
    public function setFPSOperation($value) 
    {
        $this->_fields['FPSOperation']['FieldValue'] = $value;
        return $this;
    }

    /**
     * Sets the value of the FPSOperation and returns this instance
     * 
     * @param FPSOperation $value FPSOperation
     * @return Amazon_FPS_Model_GetAccountActivityRequest instance
     */
    public function withFPSOperation($value)
    {
        $this->setFPSOperation($value);
        return $this;
    }


    /**
     * Checks if FPSOperation is set
     * 
     * @return bool true if FPSOperation  is set
     */
    public function isSetFPSOperation()
    {
        return !is_null($this->_fields['FPSOperation']['FieldValue']);
    }

    /**
     * Gets the value of the PaymentMethod property.
     * 
     * @return PaymentMethod PaymentMethod
     */
    public function getPaymentMethod() 
    {
        return $this->_fields['PaymentMethod']['FieldValue'];
    }

    /**
     * Sets the value of the PaymentMethod property.
     * 
     * @param PaymentMethod PaymentMethod
     * @return this instance
     */
    public function setPaymentMethod($value) 
    {
        $this->_fields['PaymentMethod']['FieldValue'] = $value;
        return $this;
    }

    /**
     * Sets the value of the PaymentMethod and returns this instance
     * 
     * @param PaymentMethod $value PaymentMethod
     * @return Amazon_FPS_Model_GetAccountActivityRequest instance
     */
    public function withPaymentMethod($value)
    {
        $this->setPaymentMethod($value);
        return $this;
    }


    /**
     * Checks if PaymentMethod is set
     * 
     * @return bool true if PaymentMethod  is set
     */
    public function isSetPaymentMethod()
    {
        return !is_null($this->_fields['PaymentMethod']['FieldValue']);
    }

    /**
     * Gets the value of the Role .
     * 
     * @return array of TransactionalRole Role
     */
    public function getRole() 
    {
        return $this->_fields['Role']['FieldValue'];
    }

    /**
     * Sets the value of the Role.
     * 
     * @param TransactionalRole or an array of TransactionalRole Role
     * @return this instance
     */
    public function setRole($role) 
    {
        if (!$this->_isNumericArray($role)) {
            $role =  array ($role);    
        }
        $this->_fields['Role']['FieldValue'] = $role;
        return $this;
    }
  

    /**
     * Sets single or multiple values of Role list via variable number of arguments. 
     * For example, to set the list with two elements, simply pass two values as arguments to this function
     * <code>withRole($role1, $role2)</code>
     * 
     * @param TransactionalRole  $transactionalRoleArgs one or more Role
     * @return Amazon_FPS_Model_GetAccountActivityRequest  instance
     */
    public function withRole($transactionalRoleArgs)
    {
        foreach (func_get_args() as $role) {
            $this->_fields['Role']['FieldValue'][] = $role;
        }
        return $this;
    }  
      

    /**
     * Checks if Role list is non-empty
     * 
     * @return bool true if Role list is non-empty
     */
    public function isSetRole()
    {
        return count ($this->_fields['Role']['FieldValue']) > 0;
    }

    /**
     * Gets the value of the TransactionStatus property.
     * 
     * @return TransactionStatus TransactionStatus
     */
    public function getTransactionStatus() 
    {
        return $this->_fields['TransactionStatus']['FieldValue'];
    }

    /**
     * Sets the value of the TransactionStatus property.
     * 
     * @param TransactionStatus TransactionStatus
     * @return this instance
     */
    public function setTransactionStatus($value) 
    {
        $this->_fields['TransactionStatus']['FieldValue'] = $value;
        return $this;
    }

    /**
     * Sets the value of the TransactionStatus and returns this instance
     * 
     * @param TransactionStatus $value TransactionStatus
     * @return Amazon_FPS_Model_GetAccountActivityRequest instance
     */
    public function withTransactionStatus($value)
    {
        $this->setTransactionStatus($value);
        return $this;
    }


    /**
     * Checks if TransactionStatus is set
     * 
     * @return bool true if TransactionStatus  is set
     */
    public function isSetTransactionStatus()
    {
        return !is_null($this->_fields['TransactionStatus']['FieldValue']);
    }




}