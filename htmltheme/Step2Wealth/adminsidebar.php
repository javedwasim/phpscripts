<li class="<?php
if (is_page("admin.php")) {
    echo "active";
}
?>">
    <a href="admin.php"> <span class="nav-label">Members</span></a>
</li>
<li class="<?php
if (is_page("memberslideshow.php")) {
    echo "active";
}
?>">
    <a href="memberslideshow.php"> <span class="nav-label">Slides Show</span></a>
</li>
