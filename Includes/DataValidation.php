<?php
class DataValidation {


    public static function validateAndParse($value, $type) {
        switch($type) {
            case 'date':
                return self::validateDate($value);
            case 'price':
                return self::validatePrice($value);
            case 'int':
                return self::validateInt($value);
            case 'double':
                return self::validateDouble($value);
            case 'string2':
                return self::validateString($value, 2);
            case 'string10':
                return self::validateString($value, 10);
            case 'string11':
                return self::validateString($value, 11);
            case 'string15':
                return self::validateString($value, 15);
            case 'string16':
                return self::validateString($value, 16);
            case 'string20':
                return self::validateString($value, 20);
            case 'string22':
                return self::validateString($value, 22);
            case 'string25':
                return self::validateString($value, 25);
            case 'string35':
                return self::validateString($value, 35);
            case 'string39':
                return self::validateString($value, 39);
            case 'string50':
                return self::validateString($value, 50);
            case 'string100':
                return self::validateString($value, 100);
            case 'string128':
                return self::validateString($value, 128);
            case 'string150':
                return self::validateString($value, 150);
            case 'string200':
                return self::validateString($value, 200);
            case 'string250':
                return self::validateString($value, 250);
            case 'boolean':
                return self::validateBoolean($value);
            case 'email':
                return self::validateEmail($value);
            case 'text':
                return self::validateText($value);
            case 'length':
                return self::validateLength($value);
            case 'accountType':
                return self::validateAccountType($value);
            case 'fileType':
                return self::validateFileType($value);
            case 'productType':
                return self::validateProductType($value);
            case 'password':
                return self::validatePassword($value);

            default:
                throw new Exception("Could not validate unknown data type: $type");
        }
    }

    public static function retrieveForDisplay($value, $type) {
        switch ($type) {

            //    return self::retrieveDate($value);
            case 'price':
            case 'int':
            case 'boolean':
            case 'length':
            case 'double':
            case 'date':
                return $value;
            case 'text':
            case 'string2':
            case 'string10':
            case 'string11':
            case 'string15':
            case 'string16':
            case 'string20':
            case 'string22':
            case 'string25':
            case 'string35':
            case 'string39':
            case 'string50':
            case 'string100':
            case 'string128':
            case 'string150':
            case 'string200':
            case 'string250':
            case 'productType':
            case 'accountType':
            case 'fileType':
            case 'email':
            case 'password':

                return self::retrieveString($value);
default:
                throw new Exception("Could not validate unknown data type: $type");
        }
    }

    /* Private Functions */

    /* validate functions */

    private static function validateDate($value) {
        return strtotime($value);
    }

    private static function validatePrice($value) {
        $value = str_replace('$', '', $value);
        if(!is_numeric($value)) {
            throw new Exception("Price is not a number");
        }
        if($value>100) {
            throw new Exception("Price is too high.");
        }
        if($value<=0.00) {
            throw new Exception("Price is too low.");
        }
        return (double)$value;
    }


    private static function validateLength($value) {
        if(!is_numeric($value)) {
            throw new Exception("Length is not a number");
        }
        if($value>1000) {
            throw new Exception("Length is too high.");
        }
        if($value<=0.00) {
            throw new Exception("Length is too low.");
        }
        if(strlen(substr(strrchr($value, "."), 1))>2) {
            throw new Exception("Length cannot be broken down past seconds");
        }
        return (double)$value;
    }

    private static function validateInt($value) {
        if(!is_numeric($value)) {
            throw new Exception("Not an integer");
        }
        return (int)$value;
    }

   private static function validateDouble($value) {
        if(!is_numeric($value)) {

            throw new Exception("Not a double");
        }
        return (double)$value;
    }

    private static function validateBoolean($value) {
        if(!is_bool($value) && $value!=0 && $value!=-1) {
            throw new Exception("Not a boolean");
        }
        return $value;
    }

    private static function validateText($value) {
        if(strlen($value)>65000) {
            throw new Exception("Text too large");
        }
        return mysql_real_escape_string($value);
    }

    private static function validateFileType($value) {
        if($value != 'mp3' && $value != 'wma' && $value != 'jpg' && $value != 'png') {
            throw new Exception("User Type must be mp3, wma, png or jpg");
        }
        return mysql_real_escape_string(htmlentities($value));
    }

    private static function validateAccountType($value) {
        $value = strtolower($value);
        if($value != 'customer' && $value != 'manager' && $value != 'admin') {
            throw new Exception("User Type must be customer, manager, or admin");
        }
        return mysql_real_escape_string(htmlentities($value));
    }

    private static function validateProductType($value) {
        if($value != 'DigitalMusic' && $value != 'PhysicalMusic' && $value != 'PhysicalMerch') {
            throw new Exception("Product Type must be DigitalMusic, PhysicalMusic, or PhysicalMerch");
        }
        return mysql_real_escape_string(htmlentities($value));
    }

    private static function validateString($value, $length) {
        if(strlen($value)> $length) {
            throw new Exception("String length greater than {$length}.");
        }
        return mysql_real_escape_string(htmlentities($value));
    }

    private static function validatePassword($value) {
        if(strlen($value) != 128) {
            throw new Exception("Password hash must be 128 characters");
        }
        return mysql_real_escape_string(htmlentities($value));
    }

    private static function validateEmail($value) {
        if(!self::validEmail($value)) {
            throw new Exception("Not a valid email");
        }
        return mysql_real_escape_string(htmlentities($value));
    }
    private static function validEmail($email) {
       $isValid = true;
       $atIndex = strrpos($email, "@");
       if (is_bool($atIndex) && !$atIndex)
       {
          $isValid = false;
       }
       else
       {
          $domain = substr($email, $atIndex+1);
          $local = substr($email, 0, $atIndex);
          $localLen = strlen($local);
          $domainLen = strlen($domain);
          if ($localLen < 1 || $localLen > 64)
          {
             // local part length exceeded
             $isValid = false;
          }
          else if ($domainLen < 1 || $domainLen > 255)
          {
             // domain part length exceeded
             $isValid = false;
          }
          else if ($local[0] == '.' || $local[$localLen-1] == '.')
          {
             // local part starts or ends with '.'
             $isValid = false;
          }
          else if (preg_match('/\\.\\./', $local))
          {
             // local part has two consecutive dots
             $isValid = false;
          }
          else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
          {
             // character not valid in domain part
             $isValid = false;
          }
          else if (preg_match('/\\.\\./', $domain))
          {
             // domain part has two consecutive dots
             $isValid = false;
          }
          else if
    (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                     str_replace("\\\\","",$local)))
          {
             // character not valid in local part unless
             // local part is quoted
             if (!preg_match('/^"(\\\\"|[^"])+"$/',
                 str_replace("\\\\","",$local)))
             {
                $isValid = false;
             }
          }
          if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
          {
             // domain not found in DNS
             $isValid = false;
          }
       }
       return $isValid;
    }

    /* Retrieve functions */

    private static function retrieveDate($value) {
        return date("m/d/y", $value);
    }
    private static function retrieveString($value) {
        return stripslashes($value);
    }
}
?>
