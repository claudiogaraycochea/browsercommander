<?php

    // This API could be related to a DB for control the sessions of users and folder created for them.

    header('Access-Control-Allow-Origin: *');
    
    require_once("rest.php");

    
    class API extends REST {

        public $super_user_id = 2;
    
        public $data = "";

        public $path_root = "./../../public/"; // GLOBAL PATH TO THIS DEMO.

        private $db = NULL;
    
        public function __construct(){
            parent::__construct();              // Init parent contructor
            $this->dbConnect();                 // Initiate Database connection
        }
        
        /*
         *  Database connection 
        */
        private function dbConnect(){
           // $this->db = mysqli_connect( self::DB_SERVER,self::DB_USER, self::DB_PASSWORD);
        }

        /*
         * Public method for access api.
         * This method dynmically call the method based on the query string
         *
         */
        public function processApi(){
            $func = strtolower(trim(str_replace("/","",$_REQUEST['rquest'])));
            if((int)method_exists($this,$func) > 0)
                $this->$func();
            else
                $this->response('',404);                // If the method not exist with in this class, response would be "Page not found".
        }
        
        /* 
         *  Simple login API
         *  Login must be POST method
         *  email : <USER EMAIL>
         *  pwd : <USER PASSWORD>
         */
    
        private function decode($token){
            return base64_decode($token);
        }

        private function encode($token){
            return base64_encode($token);
        }

        /*
         *  Encode array into JSON
        */
        private function json($data){
            if(is_array($data)){
                return json_encode($data);
            }
        }

        /* LIST THE DIRECTORY */
        private function listFolder(){
            if($this->get_request_method() != "GET"){
                $this->response('',406);
            }

            $user_id = '1';
            $user_token = '';

            $path= $this->_request['path'];

            if ($user_id) {

                $files = scandir($this->path_root.$path);
                //$data = $files;

                foreach ($files as $file) {
                    if (is_dir($this->path_root.$path."/".$file)) {
                        $data_pre['type']='FOLDER';
                        $data_pre['name']=$file;
                        $data[]=$data_pre;
                        //self::deleteDir($file);
                    } else {
                        $data_pre['type']='FILE';
                        $data_pre['name']=$file;
                        $data[]=$data_pre;
                    }
                }

                $this->response($this->json($data), 200);

            }

            $this->response('',204);    // If no records "No Content" status

        }

        /* USED FOR CREATE FILE OR FOLDER*/
        private function create(){
            if($this->get_request_method() != "GET"){
                $this->response('',406);
            }

            $user_id = '1';
            $user_token = '';

            $type = $this->_request['type'];
            $path = $this->_request['path'];
            $new = $this->_request['new'];
            $full_folder = $this->path_root.$path.'/'.$new;

            if ($user_id) {
                if($type == 'file'){
                    $myfile = fopen($this->path_root.$path.'/'.$new, "w");
                    $data['result'] = true;
                }
                else if ($type == 'folder'){
                    if(mkdir($full_folder, 0777)){
                        $data['result'] = true;
                    }
                    else {
                        $data['result'] = false;
                    }
                }
                
                $this->response($this->json($data), 200);
            }

            $this->response('',204);    // If no records "No Content" status

        }

        /* PRIVATE FUNCTION FOR DELETE FILE OR FOLDER */
        private function privateDeleteFolder($dirPath) {
            if (! is_dir($dirPath)) {
                unlink($dirPath);
                return true;
            }
            if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
                $dirPath .= '/';
            }
            $files = glob($dirPath . '*', GLOB_MARK);
            foreach ($files as $file) {
                if (is_dir($file)) {
                    self::deleteDir($file);
                } else {
                    unlink($file);
                }
            }
            rmdir($dirPath);
            return true;
        }

        /* USED FOR REMOVE FILE OR FOLDER */
        private function remove(){
            if($this->get_request_method() != "GET"){
                $this->response('',406);
            }

            $user_id = '1';
            $user_token = '';

            $path = $this->_request['path'];
            $remove = $this->_request['remove'];
            $full_folder = $this->path_root.$path.'/'.$remove;

            if ($user_id) {
                if($this->privateDeleteFolder($full_folder)){
                    $data['result'] = true;
                }
                else {
                    $data['result'] = false;
                }

                $this->response($this->json($data), 200);
            }

            $this->response('',204);    // If no records "No Content" status

        }

        /* USED FOR RENAME FILES OR FOLDER */
        private function rename(){
            if($this->get_request_method() != "GET"){
                $this->response('',406);
            }

            $user_id = '1';
            $user_token = '';

            $path = $this->_request['path'];
            $name = $this->_request['name'];
            $rename = $this->_request['rename'];
            $toChange = $this->path_root.$path.'/'.$name;
            $toRename = $this->path_root.$path.'/'.$rename;

            if ($user_id) {
                if(rename($toChange, $toRename)){
                    $data['result'] = true;
                }
                else {
                    $data['result'] = false;
                }
                
                $this->response($this->json($data), 200);
            }

            $this->response('',204);    // If no records "No Content" status

        }
    }



    // Initiiate Library
    
    $api = new API;
    $api->processApi();
?>