<?php

require_once('Includes/DataClassBase.php');
require_once('Includes/RequestHandlerBase.php');
require_once('DataClasses/attachment.php');
require_once('../config.php');

class CreateAttachment extends RequestHandlerBase {
    private $allowedExt = array('jpg', 'jpeg', 'png', 'gif', 'mp3', 'wma', 'flac');
    private $sizeLimit = 10485760;
    private $uploader;
    private $key;

    public function auth() {
        return true;
    }

    public function validateAndLoadData($data) {
        $this->key = $_GET['key'];
        if(!isset($_FILES[$this->key]) && !isset($_GET[$this->key])) {
            throw new Exception('No file recieved');
        }

        $this->uploader = new qqFileUploader($this->allowedExt, $this->sizeLimit, $this->key);

        return true;
    }

    public function process() {
        $myAttachment = new Attachment($this->db);

        $result = $this->uploader->handleUpload('uploads/');
        if(array_key_exists('success', $result)) {
            if(!isset($result['success'])) {
                throw new Exception('No file sent');
            }
            if(!file_exists($result['success'])) {
                throw new Exception('Uploaded file not found');
            }
            list($width, $height) = getimagesize($result['success']);

            if($width>0) {
                $myAttachment->setWidth($width);
            }
            if($height>0) {
                $myAttachment->setHeight($height);
            }
            $myAttachment->setPath(htmlentities($result['success']));
            $myAttachment->setDtExpires(time()+86400); //Files will expire in 24 hours
            $myAttachment->setIP($_SERVER['REMOTE_ADDR']);
            $myAttachment->save();
            if($myAttachment->getId()<=0) {
                $this->db->rollback();
                throw new Exception('File could not be created');
            }
        } else {
            if(array_key_exists('error', $result) && isset($result['error'])) {
                throw new Exception($result['error']);
            } else {
                throw new Exception("Upload failed: ".$result);
            }
        }

        return $myAttachment->getId();
    }
};

class qqFileUploader {
    private $allowedExtensions = array('mp3', 'wma', 'flac', 'jpg', 'png', 'gif', 'jpeg');
    private $sizeLimit = 10485760;
    private $file;
    private $key;

    function __construct(array $allowedExtensions = array(), $sizeLimit = 10485760, $key){
        $allowedExtensions = array_map("strtolower", $allowedExtensions);

        $this->allowedExtensions = $allowedExtensions;
        $this->sizeLimit = $sizeLimit;
        $this->key = $key;

        $this->checkServerSettings();

        if (isset($_GET[$this->key])) {
            $this->file = new qqUploadedFileXhr($this->key);
        } elseif (isset($_FILES[$this->key])) {
            $this->file = new qqUploadedFileForm($this->key);
        } else {
            $this->file = false;
        }
    }

    private function checkServerSettings(){
        $postSize = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));

        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';
            die("{'error':'increase post_max_size and upload_max_filesize to $size'}");
        }
    }

     private function toBytes($str){
        $val = trim($str);
        $last = strtolower($str[strlen($str)-1]);
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;
        }
        return $val;
    }

    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    public function handleUpload(){
        global $DEFAULTPATH;
        if (!is_writable($DEFAULTPATH . UPLOADPATH)){
            return array('error' => "Server error. Upload directory isn't writable.");
        }

        if (!$this->file){
            return array('error' => 'No files were uploaded.');
        }

        $size = $this->file->getSize();

        if ($size == 0) {
            return array('error' => 'File is empty');
        }

        if ($size > $this->sizeLimit) {
            return array('error' => 'File is too large');
        }

        $pathinfo = pathinfo($this->file->getName());
        $filename =  substr(md5('j*(n1323'.time() . $pathinfo['filename']), 0, 10) . '_' . $pathinfo['filename'];

        $ext = $pathinfo['extension'];

        if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
            $these = implode(', ', $this->allowedExtensions);
            return array('error' => 'File has an invalid extension, it should be one of '. $these . '.');
        }
        //Verify file type is correctly declared

       // don't overwrite previous files that were uploaded
        while (file_exists($DEFAULTPATH . UPLOADPATH . $filename . '.' . $ext)) {
            $filename .= rand(10, 99);
        }

        if ($this->file->save($DEFAULTPATH . UPLOADPATH . $filename . '.' . $ext)){
            return array('success'=>UPLOADPATH.$filename.'.'.$ext);
        } else {
            return array('error'=> 'Could not save uploaded file.' .
                'The upload was cancelled, or server error encountered');
        }

    }
};

abstract class  qqUploadedFile {
    protected $key;

    function __construct($key) {
        $this->key = $key;
    }

    abstract function save($path);
    abstract function getName();
    abstract function getSize();
};

class qqUploadedFileXhr extends qqUploadedFile {
        /**
         * Save the file to the specified path
         * @return boolean TRUE on success
         */
        function save($path) {
            $input = fopen("php://input", "r");
            $temp = tmpfile();
            $realSize = stream_copy_to_stream($input, $temp);
            fclose($input);

            if ($realSize != $this->getSize()){
                return false;
            }

            $target = fopen($path, "w");
            fseek($temp, 0, SEEK_SET);
            stream_copy_to_stream($temp, $target);
            fclose($target);
            if($line = $this->verifyFile($path)) {
                unlink($path);
                throw new Exception($line);
            }

            return true;
        }
        function verifyFile($filepath){
            $pathinfo = pathinfo($filepath);
            if(strstr($pathinfo['filename'], '.php')) {
                return "Invalid file type provided";
            }
            /*$ext = $pathinfo['extension'];
            if($ext=='gif' && mime_content_type($filepath)!='image/gif') {
                return 'File has a gif extension, but is not a gif';
            }
            echo "hello: $filepath";
            echo mime_content_type($filepath);
            if(($ext=='jpg' || $ext=='jpeg') && mime_content_type($filepath)!='image/jpg' && mime_content_type($filepath)!='image/jpeg') {
                return 'File has a jpg/jpeg extension, but is not a jpeg';
            }
            if($ext=='png' && mime_content_type($filepath)!='image/png') {
                return 'File has a png extension, but is not a png';
            }
            if($ext=='mp3' && (mime_content_type($filepath)!='audio/mpeg3' || mime_content_type($filepath)!='audio/x-mpeg-3')) {
                return 'File has an mp3 extension, but is not a mp3';
            }
            if($ext=='wma' && mime_content_type($filepath)!='audio/x-ms-wma') {
                return 'File has a wma extension, but is not a wma';
            }
            if($ext=='flac' && mime_content_type($filepath)!='audio/flac') {
                return 'File has a flac extension, but is not a flac';
            }*/
            return '';
        }
        function getName() {
            return $_GET[$this->key];
        }
        function getSize() {
            if (isset($_SERVER["CONTENT_LENGTH"])){
                return (int)$_SERVER["CONTENT_LENGTH"];
            } else {
                throw new Exception('Getting content length is not supported.');
            }
        }
    };

class qqUploadedFileForm extends qqUploadedFile {
        /**
         * Save the file to the specified path
         * @return boolean TRUE on success
         */
        function save($path) {
            if($line = $this->verifyFile($_FILES[$this->key]['tmp_name'])) {
                throw new Exception($line);
            }
            if(!move_uploaded_file($_FILES[$this->key]['tmp_name'], $path)){
                return false;
            }
            return true;
        }
        function verifyFile($filepath){
            $pathinfo = pathinfo($filepath);
            if(strstr($pathinfo['filename'], '.php')) {
                return "Invalid file type provided";
            }

            /*$ext = $pathinfo['extension'];
            if($ext=='gif' && mime_content_type($filepath)!='image/gif') {
                return 'File has a gif extension, but is not a gif';
            }

            if(($ext=='jpg' || $ext=='jpeg') && (mime_content_type($filepath)!='image/jpg'||mime_content_type($filepath)!='image/jpeg')) {
                return 'File has a jpeg extension, but is not a jpeg';
            }
            
            if(($ext=='jpg' || $ext=='jpeg') && (mime_content_type($filepath)!='image/jpg'||mime_content_type($filepath)!='image/jpeg')) {
                return 'File has a jpeg extension, but is not a jpeg';
            }
            if($ext=='png' && mime_content_type($filepath)!='image/png') {
                return 'File has a png extension, but is not a png';
            }
            if($ext=='mp3' && (mime_content_type($filepath)!='audio/mpeg3' || mime_content_type($filepath)!='audio/x-mpeg-3')) {
                return 'File has an mp3 extension, but is not a mp3';
            }
            if($ext=='wma' && mime_content_type($filepath)!='audio/x-ms-wma') {
                return 'File has a wma extension, but is not a wma';
            }
            if($ext=='flac' && mime_content_type($filepath)!='audio/flac') {
                return 'File has a flac extension, but is not a flac';
            }*/
            return '';
        }
        function getName() {
            return $_FILES[$this->key]['name'];
        }
        function getSize() {
            return $_FILES[$this->key]['size'];
        }
    };

?>