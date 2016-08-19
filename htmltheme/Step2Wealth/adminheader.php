<?php
require_once("includes/initialize.php");
if (!$session->is_Admin_logged_in() || empty($_SESSION["AdminEmail"])) { //If Not Login
    redirect_JS("login.php");
    die();
} else {
    //Assign Session to global variables---------------------------------------
    global $userID, $currentUserEmail, $contaFullName, $currentUserRole;
    $userID = $session->Admin_ID;
    $currentUserEmail = $_SESSION["AdminEmail"];
    if (isset($_SESSION["AdminFullName"])) {
        $contaFullName = $_SESSION["AdminFullName"];
    }
    $contactProfilePic = "profileimg/no-profile.png";
    if (isset($_SESSION["AdminProfilePic"])) {
        $contactProfilePic = $_SESSION["AdminProfilePic"];
    } else {
        $contactProfilePic = "profileimg/no-profile.png";
    }
    if (isset($_SESSION['AdminRole'])) {
        $currentUserRole = $_SESSION['AdminRole'];
    }
}
// For Pages Previiges Only open Page with required permission----------------------------
member_pages_previliges();
?>
<!DOCTYPE html>
<html>
    <head><?php require_once 'head.php'; ?></head>
    <body>

        <!-- Simple splash screen-->
        <div class="splash"> <div class="color-line"></div>
            <div class="splash-title">
                <img src="images/loading-bars.svg" width="64" height="64" /> 
            </div>
        </div>
        <!--[if lt IE 7]>
        <p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Header -->
        <?php include_once 'topbar.php'; ?>
        <!-- Navigation -->
        <aside id="menu">
            <div id="navigation">
                <ul class="nav" id="side-menu">
                    <?php
                    include_once("adminsidebar.php");
                    ?>
                </ul>
            </div>
        </aside>
        <!-- Main Wrapper -->
        <div id="wrapper">
            <?php include_once 'pageheading.php'; ?>