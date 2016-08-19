<li class="<?php if (is_home_page()) { echo "active";} ?>">
    <a href="index.php"> <span class="nav-label">Dashboard</span>  </a>
</li>
<li class="<?php if (is_page("myproducts.php")) { echo "active";} ?>">
    <a href="myproducts.php"> <span class="nav-label">My Products</span></a>
</li>
<li class="<?php if (is_page("training.php")) { echo "active";} ?>">
    <a href="training.php"> <span class="nav-label">Training</span></a>
</li>
<li class="<?php if (is_page("referral.php")) { echo "active";}?>">
    <a href="referral.php"> 
        <span class="nav-label">Refer People for </span>
        <span class="label label-success pull-right text-12">
            <i class="fa fa-dollar"></i>
        </span> 
    </a>
</li>
<li class="<?php
if (is_page("slideshow.php")) {
    echo "active";
}
?>">
    <a href="slideshow.php"> <span class="nav-label">Make Content For</span><span class="label label-success pull-right text-12"><i class="fa fa-dollar"></i></span> </a>
</li>
<li class="<?php
if (is_page("existingslideshow.php")) {
    echo "active";
}
?>">
    <a href="existingslideshow.php"> 
        <span class="nav-label">Share Content For</span><span class="label label-success pull-right text-12"><i class="fa fa-dollar"></i></span> 
    </a>
</li>

<li class="<?php
if (is_page("stats.php")) {
    echo "active";
}
?>">
    <a href="stats.php"> 
        <span class="nav-label">Stats</span> 
    </a>
</li>