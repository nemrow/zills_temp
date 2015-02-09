<?php
require_once('../config.php');
require_once('lang/'.LANGUAGE.'/errors.php');
require_once('Includes/PageBase.php');
require_once('Pages/error.php');

// Request controller
if(isset($_GET['page'])) {
    $page = strtolower($_GET['page']);
} else {
    $page = "index";
}


$file = $DEFAULTPATH.'Pages/'.$page.'.php';


if(file_exists($file)) {
    require_once($file);

    if(class_exists($page)) {
        $instance = new $page();

        if(method_exists($instance, 'init')) {
            try {
                if(!$instance->init($_POST)) {
                    handleError(C119_INITRETURNFALSE);
                }
            } catch (Exception $e) {
                handleError($e->getMessage());
            }
        } else {
            handleError(C120_INITNOTSUPPORTED);
        }

        if(method_exists($instance, 'header')) {
            try {
                if(!$instance->header()) {
                    handleError(C110_HEADERRETURNFALSE);
                }
            } catch (Exception $e) {
                handleError($e->getMessage());
            }
        } else {
            handleError(C111_HEADERNOTSUPPORTED);
        }

        if(method_exists($instance, 'body')) {
            try {
                if(!$instance->body()) {
                    handleError(C112_BODYRETURNFALSE);
                }
            } catch (Exception $e) {
                handleError($e->getMessage());
            }
        } else {
            handleError(C113_BODYNOTSUPPORTED);
        }

        if(method_exists($instance, 'footer')) {
            try {
                if(!$instance->footer()) {
                    handleError(C114_FOOTERRETURNFALSE);
                }
            } catch (Exception $e) {
                handleError($e->getMessage());
            }
        } else {
            handleError(C115_FOOTERNOTSUPPORTED);
        }

    } else {
        handleError(C105_CLASSNOTSUPPORTED);
    }
} else {
    handleError(C106_REQUESTNOTFOUND);
}

function handleError($error) {
    if(class_exists('error')) {
        $instance = new error();
        if(method_exists($instance, 'init')) {
            try {
                if(!$instance->init($error)) {
                    die(C119_INITRETURNFALSE);
                }
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            die(C120_INITNOTSUPPORTED);
        }

        if(method_exists($instance, 'header')) {
            try {
                if(!$instance->header()) {
                    die(C110_HEADERRETURNFALSE);
                }
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            die(C111_HEADERNOTSUPPORTED);
        }

        if(method_exists($instance, 'body')) {
            try {
                if(!$instance->body()) {
                    die(C112_BODYRETURNFALSE);
                }
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            die(C113_BODYNOTSUPPORTED);
        }

        if(method_exists($instance, 'footer')) {
            try {
                if(!$instance->footer()) {
                    die(C114_FOOTERRETURNFALSE);
                }
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            die(C115_FOOTERNOTSUPPORTED);
        }
    } else {
        die(C105_CLASSNOTSUPPORTED);
    }
    die();
}

?>
