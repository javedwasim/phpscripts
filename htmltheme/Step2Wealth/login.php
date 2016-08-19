<?php 
require_once("includes/initialize.php");
//if($session->is_logged_in()) {
//  redirect_to("index.php");
//} 
extract(getHttpVars());
$CurrentDateTime = date('Y-m-d,H:i:s', time());
// Remember to give your form's submit tag a name="submit" attribute!
if (isset($_POST['formSubmited']) && $_POST['formSubmited']=='formSubmited') { // Form has been submitted.
  $email = trim($_POST['username']);
  $password = trim($_POST['password']);
  
    $contactGlobalObj->setContactEmail($email);
    $contactGlobalObj->setPassword($password);
    $contactData = $contactGlobalObj->authenticateContact();
    if(!empty($contactData)){
        if ($contactGlobalObj->isIsAdmin($contactData[0]['Id'])) {
            $session->Adminlogin($contactData);
            redirect_JS("admin.php");
        }elseif($contactGlobalObj->isIsMember($contactData[0]['Id'])){
            $session->login($contactData);
            redirect_JS("index.php");
        }else{
            $session->message("You have no permission to login.");
            redirect_JS("login.php");
             die();
        }
    } //END OF if(!empty($contactData)){
   else{
       $session->message("Please enter valid login detail.");
        redirect_JS("login.php");
        die();
   }
  }else { // Form has not been submitted.
  $username = "";
  $password = "";
}

?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>Step2Wealth - Make money by creating and sharing viral content</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="vendor/bootstrap/dist/css/bootstrap.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="styles/style.css">

</head>
<body class="blank">

<!-- Simple splash screen-->
<div class="splash"> <div class="color-line"></div><div class="splash-title"><img src="images/loading-bars.svg" width="64" height="64" /> </div> </div>
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div class="color-line"></div>
<!--
<div class="back-link">
    <a href="index.php" class="btn btn-primary">Back to Dashboard</a>
</div>
-->
<div class="login-container">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center m-b-md">
                <h3>PLEASE LOGIN TO APP</h3>
            </div>
            <div class="hpanel">
				<?php if(!empty($message)){ ?>
				<div class="alert alert-danger text-center">
					<strong><?php echo $message; ?></strong>
				</div>
				<?php } ?>
                <div class="panel-body">
                        <form action="" id="loginForm" method="post">
                            <div class="form-group">
                                <label class="control-label" for="username">Username</label>
                                <input type="text" placeholder="example@gmail.com" title="Please enter you username" required="" value="<?php if(!empty($username)){echo $username;} ?>" name="username" id="username" class="form-control">
                                <span class="help-block small">Your unique username to app</span>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <input type="password" title="Please enter your password" placeholder="******" required="" value="<?php if(!empty($password)){ echo $password; } ?>" name="password" id="password" class="form-control">
                                <span class="help-block small">Your strong password</span>
                            </div>
                            <div class="checkbox">
                                <input type="checkbox" class="i-checks" checked>
                                     Remember login
                                <p class="help-block small">(if this is a private computer)</p>
                            </div>
                            <input type="hidden" name="formSubmited" id="formSubmited" value="formSubmited" />
                            <button class="btn btn-success btn-block" type="submit" name="submit">Login</button>
							<!--
                            <a class="btn btn-default btn-block" href="#">Register</a>-->
                        </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <br/> 2015 © Step2Wealth
        </div>
    </div>
</div>


<!-- Vendor scripts -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="vendor/iCheck/icheck.min.js"></script>
<script src="vendor/sparkline/index.js"></script>

<!-- App scripts -->
<script src="scripts/homer.js"></script>

</body>
</html>