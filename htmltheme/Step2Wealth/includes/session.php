<?php

// A class to help work with Sessions
// In our case, primarily to manage logging users in and out
// Keep in mind when working with sessions that it is generally 
// inadvisable to store DB-related objects in sessions



class Session {

    private $logged_in = false;
    private $Admin_logged_in = false;
    public $User_ID;
    public $Admin_ID;
    public $message;

    function __construct() {

        session_start();

        $this->check_message();

        $this->check_login();
        $this->check_Admin_login() ;
        if ($this->logged_in) {

            // actions to take right away if user is logged in
        } else {

            // actions to take right away if user is not logged in
        }
    }

    public function is_logged_in() {

        return $this->logged_in;
    }
    public function is_Admin_logged_in() {

        return $this->Admin_logged_in;
    }

    public function login($contactData) {
        if ($contactData) {
            $contactFullName = isset($contactData[0]['FirstName'])? $contactData[0]['FirstName']: "";
            $contactFullName .= isset($contactData[0]['LastName'])? " ".$contactData[0]['LastName']: "";
            $this->User_ID = $_SESSION['User_ID'] = $contactData[0]['Id'];
            $this->logged_in = true;
            $_SESSION["currentUserEmail"] = $contactData[0]['Email'];
            $_SESSION["currentUserRole"] = $contactData[0]['_Role'];
            $_SESSION["contaFullName"] = $contactFullName;
            if (isset($contactData[0]['_ProfileImage'])) {
                $_SESSION["contactProfilePic"] = $contactData[0]['_ProfileImage'];
            }
        }
    }
    public function Adminlogin($contactData) {
        if ($contactData) {
            $contactFullName = isset($contactData[0]['FirstName'])? $contactData[0]['FirstName']: "";
            $contactFullName .= isset($contactData[0]['LastName'])? " ".$contactData[0]['LastName']: "";
            $this->Admin_ID = $_SESSION['Admin_ID'] = $contactData[0]['Id'];
            $this->Admin_logged_in = true;
            $_SESSION["AdminEmail"] = $contactData[0]['Email'];
            $_SESSION["AdminRole"] = $contactData[0]['_Role'];
            $_SESSION["AdminFullName"] = $contactFullName;
            if (isset($contactData[0]['_ProfileImage'])) {
                $_SESSION["AdminProfilePic"] = $contactData[0]['_ProfileImage'];
            }
        }
    }

    public function logout() {

        unset($_SESSION['User_ID']);

        unset($this->User_ID);

        $this->logged_in = false;
    }
     public function Adminlogout() {

        unset($_SESSION['Admin_ID']);
        unset($_SESSION['AdminRole']);
        unset($_SESSION['AdminEmail']);
        unset($_SESSION['AdminFullName']);
        unset($_SESSION['AdminProfilePic']);

        unset($this->Admin_ID);

        $this->Admin_logged_in = false;
    }
     public function Memberlogout() {

        unset($_SESSION['User_ID']);
        unset($_SESSION['currentUserEmail']);
        unset($_SESSION['currentUserRole']);
        unset($_SESSION['contaFullName']);
        unset($_SESSION['contactProfilePic']);
        unset($this->User_ID);

        $this->logged_in = false;
    }

    public function message($msg = "") {

        if (!empty($msg)) {

            // then this is "set message"
            // make sure you understand why $this->message=$msg wouldn't work

            $_SESSION['message'] = $msg;
        } else {

            // then this is "get message"

            return $this->message;
        }
    }

    private function check_login() {

        if (isset($_SESSION['User_ID'])) {

            $this->User_ID = $_SESSION['User_ID'];

            $this->logged_in = true;
        } else {

            unset($this->User_ID);

            $this->logged_in = false;
        }
    }
    private function check_Admin_login() {

        if (isset($_SESSION['Admin_ID'])) {

            $this->Admin_ID = $_SESSION['Admin_ID'];

            $this->Admin_logged_in = true;
        } else {

            unset($this->Admin_ID);

            $this->Admin_logged_in = false;
        }
    }

    private function check_message() {

        // Is there a message stored in the session?

        if (isset($_SESSION['message'])) {

            // Add it as an attribute and erase the stored version

            $this->message = $_SESSION['message'];

            unset($_SESSION['message']);
        } else {

            $this->message = "";
        }
    }

}

global $session;
$session = new Session();

$message = $session->message();
?>