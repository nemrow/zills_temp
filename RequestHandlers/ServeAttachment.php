<?php

require_once('Includes/DataClassBase.php');
require_once('Includes/RequestHandlerBase.php');
require_once('DataClasses/attachment.php');
require_once('../config.php');

class ServeAttachment extends RequestHandlerBase {
    private $id;
    private $x;
    private $y;

    public function auth() {
        return true;
    }

    public function validateAndLoadData($data) {
        if(array_key_exists('id', $_GET)) {
            if(!is_numeric($_GET['id'])) {
                throw new Exception("Invalid id");
            }
            $this->id = (int)$_GET['id'];
        } else {
            throw new Exception("No attachment specified");
        }

        if(array_key_exists('x', $_GET)) {
            if(!is_numeric($_GET['x'])) {
                throw new Exception("Invalid x");
            }
            $this->x = (int)$_GET['x'];
        }

        if(array_key_exists('y', $_GET)) {
            if(!is_numeric($_GET['id'])) {
                throw new Exception("Invalid y");
            }
            $this->y = (int)$_GET['y'];
        }
        return true;
    }

    public function process() {
        $myAttachment = new Attachment($this->db);
        $myAttachment->read($this->id);



        header("Location: {$myAttachment->getPath()}");

        return '';
    }
};
