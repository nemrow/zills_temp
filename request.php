<?php
require_once('../config.php');
require_once('lang/'.LANGUAGE.'/errors.php');


// Request controller
if(isset($_POST['requestType']) || isset($_GET['requestType'])) {
    if(!isset($_POST['requestType'])) {
        $request = $_GET['requestType'];
    } else {
        $request = $_POST['requestType'];
    }

    $requestFile = $DEFAULTPATH.'/RequestHandlers/'.$request.'.php';
    if(file_exists($requestFile)) {
        require_once($requestFile);

        if(class_exists($request)) {
            $instance = new $request();

            if(method_exists($instance, 'validateAndLoadData')) {
                try {
                    if(!$instance->validateAndLoadData($_POST)) {
                        die(C100_VALIDATERETURNFALSE);
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                die(C101_VALIDATENOTSUPPORTED);
            }

            if(method_exists($instance, 'auth')) {

                if($instance->auth()) {
                    try {
                        if(method_exists($instance, 'process')) {
                            echo $instance->process();
                        } else {
                            die(C102_PROCESSNOTSUPPORTED);
                        }

                    } catch (Exception $e) {
                        die($e->getMessage());
                    }
                } else {
                    die(C103_AUTHRETURNFALSE);
                }
            } else {
                die(C104_AUTHNOTSUPPORTED);
            }
        } else {
            die(C105_CLASSNOTSUPPORTED);
        }
    } else {
        die(C106_REQUESTNOTFOUND);
    }
} else {
    die(C107_REQUESTNOTSPECIFIED);
}

?>
