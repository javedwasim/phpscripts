<?php 
@include("config.php");
@include("class/Main.class.php");
$Main = new Main();
$Main->pagetitle="User Management";

/*BEGIN USER MANAGEMENT FUNCTIONS ASSIGN */
if(isset($_POST['user_addnew']))
{
	array_splice($_POST, -1);	//WILL REMOVE LAST ELEMENT (SUBMIT BUTTON KEY AND VALUE)
	$insert_id = $Main->InsertRecord("user_master",$_POST);

	if($insert_id>0)
	{
		$_SESSION['message'] = array("status"=>1,"message"=>"Record has been added successfully.");
	}
	$Main->RedirectPage($Main->pagefilename);
}
else if(isset($_POST['user_edit']) && isset($_GET['action']) && $_GET['action']=="edit" && isset($_GET['id']) && is_numeric($_GET['id']))
{
	array_splice($_POST, -1);	//WILL REMOVE LAST ELEMENT (SUBMIT BUTTON KEY AND VALUE)
	$records = $Main->UpdateRecord("user_master",$_POST,"user_id='".$_GET['id']."'");
	if($records>0)
	{
		$_SESSION['message'] = array("status"=>1,"message"=> " Record has been updated successfully.");
	}
	$Main->RedirectPage($Main->pagefilename);
}
else if(isset($_GET['action']) && $_GET['action']=="delete" && isset($_GET['id']))
{
	$records = $Main->DeleteRecord("user_master","user_id='".$_GET['id']."'");
	if($records>0)
	{
		$_SESSION['admin_message'] = array("status"=>1,"message"=> " Record has been deleted successfully.");
	}
	$Main->RedirectPage($Main->pagefilename);
}
else if(isset($_GET['action']) && $_GET['action']=="status" &&  isset($_GET['status']) && is_numeric($_GET['status']) && isset($_GET['id']))
{
	$info_array = array("active_status"=>$_GET['status']);
	$records = $Main->UpdateRecord("user_master",$info_array,"user_id='".$_GET['id']."'");
	if($records>0)
	{
		$_SESSION['admin_message'] = array("status"=>1,"message"=> " Active status has been changed successfully.");
	}
	$Main->RedirectPage($Main->pagefilename);
}

/*END USER MANAGEMENT FUNCTIONS ASSIGN */
?>
<!--========================================Insert Record============================================= -->
<?php
/* $password = md5("12345");
$info_array = array("firstname"=>"bharat383","lastname"=>"test","email"=>"bharatparmar383@gmail.com","password"=>$password,"active_status"=>1);
$insert_id = $Main->InsertRecord("user_master", $info_array); */
?>
<!-- ========================================Update Record============================================= -->
<?php 
	/* $array = array("firstname"=>"javed", "lastname"=>"wasim");
	$Main->UpdateRecord("user_master",$array, $where="user_id='20'");  */
?>
<!-- ========================================Date Difference============================================= -->
<?php $datediff = $Main->DateDifference("2015-09-21 12:30:00","2015-09-25 19:00:00"); print_r($datediff); ?>

<?php if(isset($_GET['action']) && ($_GET['action']=="addnew" || $_GET['action']=="edit")) { 

	if($_GET['action']=="edit")
	{
		$info_array = array("where"=>"user_id='".$_GET['id']."'");
		$userdata = $Main->GetSingleRecord("user_master",$info_array);
	}		

	?>

	<form method="post" enctype="multipart/form-data">

	        <div class="form-group">
		        <lable>First Name</lable>
		        <input type="text" name="firstname" id="firstname" class="form-control alphanumeric" value="<?php echo stripslashes(@$userdata['firstname']);?>" title="Enter First Name">
	        </div>

	        <div class="form-group">
		        <lable>Last Name</lable>
		        <input type="text" name="lastname" id="lastname" class="form-control alphanumeric" value="<?php echo stripslashes(@$userdata['lastname']);?>" title="Enter Last Name">
	        </div>

	        <div class="form-group">
		        <lable>Email</lable>
		        <input type="text" name="email" id="email" class="form-control" value="<?php echo stripslashes(@$userdata['email']);?>" title="Enter Email">
	        </div>

	        <div class="form-group">
		        <lable>Password</lable>
		        <input type="text" name="password" id="password" class="form-control" value="" placeholder="Enter Password Only If You Want to Set/Change it.">
	        </div>

        	<div class="form-group">
		        <lable>Active Status</lable>
		        <select name="active_status" id="active_status" class="form-control">
		        	<option value="1" <?php if(@$userdata['active_status']=="1") echo "selected"; ?>>Active</option>
					<option value="0" <?php if(@$userdata['active_status']=="0") echo "selected"; ?>>Inactive</option>	
		        </select>
	        </div>

	        <div class="btn-toolbar list-toolbar">
		      	<input type="submit" name="user_<?php echo $_GET['action'];?>" value="Save" class="btn btn-primary">
				<input type="button" name="cancel_button" value="Cancel" onclick="window.location='user.php';" class="btn btn-default">
		    </div>
      	</form>
<?php } else { ?>



<table class="table table-hover" id="datarecord">
	<thead>
	    <tr>
		    <th>User ID</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>Register Date</th>
			<th>Action</th>
	    </tr>
	</thead>
  	<tbody>
  		<?php
  			$startfrom = 0;
  			$limit=$_SESSION['pagerecords_limit'];

  			if(isset($_GET['page']) && is_numeric($_GET['page']))
  			{
  				$startfrom= ($_GET['page']*$_SESSION['pagerecords_limit']-$_SESSION['pagerecords_limit']);	
  			} 

			$info_array = array(
									"orderby"=>"user_id",
									"ordertype"=>"desc",
									"limit"=>$limit,
									"startfrom"=>$startfrom
								);
			$records = $Main->GetRecord("user_master",$info_array);

			$srno=$startfrom;
			if(@count($records)>0)
			{	
				foreach($records as $key=>$value)
				{
					?>	
						<tr>
							<td><?php echo $value['user_id']; ?></td>
							<td><?php echo stripslashes($value['firstname']); ?></td>
							<td><?php echo stripslashes($value['lastname']); ?></td>
							<td><?php echo stripslashes($value['email']); ?></td>
							<td><?php echo date("d-m-Y H:i:s",strtotime($value['register_date'])); ?></td>
							<td>
								<?php if($value['active_status']==0) { ?>
								 	<a href="<?php echo $Main->StatusLink($value['user_id'],1);?>"><span  class="label label-danger">Inactive</span></a>
								<?php } else { ?>
									<a href="<?php echo $Main->StatusLink($value['user_id'],0);?>"><span  class="label label-success">Active</span></a>	
								<?php } ?>

								<a href="<?php echo $Main->DeleteLink($value['user_id']);?>" class="label label-danger" onclick="return confirm('Are You Sure To Delete This Record?');" style="margin-right:4px;">
								<i class="fa fa-times"></i> Delete </a>
							</td>
						</tr>
					<?php	
				}
			}
			else
			{
				echo "<tr><td colspan='4' align='center'>Records not available.</td></tr>";
			}

		?>
    </tbody>
</table>

<?php $Main->PagiNation("user_master","user_id");?>

<?php } ?>

