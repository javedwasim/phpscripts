<?php
@include("../config.php");
class Main
{

	/* BEGIN __CONSTRUNCT FUNCITON FOR THE MAIN CLASS */
		public function __construct()
		{
			/*BEGIN SETTING PAGE PER RECORD */
				if(isset($_GET['record']) && is_numeric($_GET['record']))
				{
					$_SESSION['pagerecords_limit']=$_GET['record'];
				}
			/* END SETTING PAGE PER RECORD */		


			$this->pagefilename = basename($_SERVER['PHP_SELF']);

			
		}
	/* END __CONSTRUNCT FUNCITON FOR THE MAIN CLASS */	

	/*BEGIN PAGE REDIRECTION FUNCTION */
		public function RedirectPage($url)
		{
			if($url!="")
			{
				echo '<script type="text/javascript">window.location="'.$url.'";</script>';
				exit;
			}
		}
	/*END PAGE REDIRECTION FUNCTION : RedirectPage()*/

	/*BEGIN VIEW LINK CREATION FUNCTION */
		public function ViewLink($id)
		{
			echo $this->pagefilename.'?action=view&id='.$id;
		}
	/*END EDIT LINK CREATION FUNCTION */

	/*BEGIN EDIT LINK CREATION FUNCTION */
		public function EditLink($id)
		{
			echo $this->pagefilename.'?action=edit&id='.$id;
		}
	/*END EDIT LINK CREATION FUNCTION */

	/*BEGIN STATUS CHANGE LINK CREATION FUNCTION */
		public function StatusChangeLink($id,$currentstatus)
		{
			if($currentstatus=="0")
			{
				echo '<a href="'.$this->pagefilename.'?action=status&status=1&id='.$id.'"><span  class="label label-danger">Inactive</span></a>';
			}
			else
			{
				echo '<a href="'.$this->pagefilename.'?action=status&status=0&id='.$id.'"><span  class="label label-success">Active</span></a>';
			}
		}
		public function StatusLink($id,$status=0)
		{
			echo $this->pagefilename.'?action=status&status='.$status.'&id='.$id;
		}
	/*END STATUS CHANGE LINK CREATION FUNCTION */

	/*BEGIN DELETE LINK CREATION FUNCTION */
		public function DeleteLink($id)
		{
			echo $this->pagefilename.'?action=delete&id='.$id;
		}
	/*END DELETE LINK CREATION FUNCTION */
	
	/*BEGIN SEND MAIL FUNCTION */
		public function SendMail($mailto,$subject,$message,$attachments="")
		{
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			// Additional headers
			//$headers .= 'To: user <user@example.com>, User2 <user2@example.com>' . "\r\n";
			$headers .= 'From: User Test <usertest@example.php>' . "\r\n";
			@mail($mailto,$subject,$message,$headers);
			
		}
	/*END SEND MAIL FUNCTION : SendMail()  */

	/*BEGIN GET RANDOM STRING FUNCTION */
		public function GetRandomString($length,$type=0) 
		{
		    $key = '';
		    if($type==1)		//NUMERIC ONLY
		    {
		    	$keys = range(0, 9);
		    }
		    else if($type==2)	//APHA ONLY
		    {
		    	$keys = range('a', 'z');
		    }
		    else
		    {
		    	$keys = array_merge(range(0, 9), range('a', 'z'));
		    }

		    for ($i = 0; $i < $length; $i++) 
		    {
		        $key .= $keys[array_rand($keys)];
		    }

	    	return $key;
		}
	/*END GET RANDOM STRING FUNCTION : GetRandomString() */

	/*BEGIN DATABASE RECORD FUNCTION */

		/*BEGIN INSERT RECORD FUNCTION */
			public function InsertRecord($tablename, array $values)
			{
				/*
					REQUIREMENT : 
						$tablename : Table Name where data will be inserted
						$values :  array 
									field_1 => value_1,field_2 => value_2,field_3 => value_3,field_n => value_n

									fields name and values which will be added for the record

					RETURN : LAST INSERTED IDs
				*/

				$last_inserted_id=0;	

				if(TABLE_PREFIX!="")
				{
					$tablename = TABLE_PREFIX.$tablename;
				}

				if(!empty($values))
				{
					$query_string = "insert into ".$tablename." set ";

					foreach($values as $key=>$value)
					{
						$query_string.=$key." = '".addslashes($value)."' , ";	
					}

					$query_string = trim($query_string," , ");

					/* TO CHECK QUERY REMOVE ENABLE BELOW CODE */
					//echo $query_string;exit;

					mysql_query($query_string) or die(mysql_error());

					$last_inserted_id = mysql_insert_id();
				}

				return $last_inserted_id;
			}
		/*END INSERT RECORD FUNCTION : InsertRecord()*/

		/*BEGIN INSERT MULTIPLE RECORD FUNCTION */
			public function InsertMultipleRecord($tablename,$fieldarray,$valuearray)
			{
				if(TABLE_PREFIX!="")
				{
					$tablename = TABLE_PREFIX.$tablename;
				}

				$query_string = "insert into ".$tablename." (";
				foreach ($fieldarray as $key => $value) 
				{
					$query_string.="`".$value."` ,";
				}
				
				$query_string = trim($query_string," ,");

				$query_string.=" ) values ";

				foreach ($valuearray as $key => $value) 
				{
					$query_string.=" ( ";
					foreach ($value as $k => $v) 
					{
						$query_string.="'".addslashes($v)."' ,";	
					}

					$query_string.=" ) ,";
					
				}
				$query_string = trim($query_string," ,");


				/* TO CHECK QUERY REMOVE ENABLE BELOW CODE */
				//echo $query_string;exit;

				mysql_query($query_string) or die(mysql_error());

				//$last_inserted_id = mysql_insert_id();

				$totalnewrecord = mysql_affected_rows();

				return $totalnewrecord;				

			}
		/*END INSERT MULTIPLE RECORD FUNCTION */

		/*BEGIN GET SINGLE RECORD FUNCTION */
			public function GetSingleRecord($tablename,array $array)
			{
				/*
					REQUIREMENT : 
						$tablename : Table Name where data will be inserted
						$array :  array 
								fields : * or field_1, field_2, field_n #BY DEFAULT *	
								where : where condition as per your requirement 
					RETURN : RECORD ARRAY
				*/

				if(TABLE_PREFIX!="")
				{
					$tablename = TABLE_PREFIX.$tablename;
				}

				$record = array();

				if(!isset($array['fields']) || $array['fields']=="") {$array['fields']="*";}

				$query_string = "select ".$array['fields']." from ".$tablename." where 1=1 "; 	

				if(@$array['where']!="")
				{
					$query_string.=" and ".$array['where']." ";
				}

				/* TO CHECK QUERY REMOVE ENABLE BELOW CODE */
				//echo $query_string;exit;

				$query = mysql_query($query_string) or die(mysql_error());
				if(@mysql_num_rows($query)>0)
				{
					$record = mysql_fetch_assoc($query);
				} 
				return $record;
			}
		/*END GET SINGLE RECORD FUNCTION */
		
		/*BEGIN GET RECORD FUNCTION */
			public function GetRecord($tablename,array $array)
			{
				/*
					REQUIREMENT : 
						$tablename : Table Name where data will be inserted
						$array :  array 
								fields : * or field_1, field_2, field_n #BY DEFAULT *	
								where : where condition as per your requirement 
								orderby	: order by parameter : #BY DEFAULT PRIMARY KEY
								ordertype	: order type parameter : #BY DEFAULT PRIMARY KEY desc
								limit : limit of the record, 10 or 20 or n...
								startfrom : record starts from
								groupby : group by
					RETURN : RECORD ARRAY
				*/

				if(TABLE_PREFIX!="")
				{
					$tablename = TABLE_PREFIX.$tablename;
				}

				$record = array();

				if(!isset($array['fields']) || $array['fields']=="") {$array['fields']="*";}

				$query_string = "select ".$array['fields']." from ".$tablename." where 1=1 "; 	

				if(@$array['where']!="")
				{
					$query_string.=" and ".$array['where']." ";
				}

				//seeting order by
				if(@$array['orderby']=="") 
				{
					$array['orderby']=1;
				}

				//setting order type
				if(@$array['ordertype']=="") 
				{
					$array['ordertype']="desc";
				}

				$query_string.=" order by ".$array['orderby']." ".$array['ordertype'];

				//setting group by
				if(@$array['groupby']!="") 
				{
					$query_string.=" group by ".$array['groupby'];
				}

				//setting record start limit
				if(@$array['startfrom']=="") 
				{
					$array['startfrom']=0;
				}

				//setting record limit
				if(@$array['limit']>0 && is_numeric(@$array['limit']))
				{
					$query_string.=" limit ".$array['startfrom'].", ".$array['limit'];
				}

				/* TO CHECK QUERY REMOVE ENABLE BELOW CODE */
				//echo $query_string;exit;

				$query = mysql_query($query_string) or die(mysql_error());
				if(@mysql_num_rows($query)>0)
				{

					while($data=mysql_fetch_assoc($query)) 
					{
						$record[] = $data;
					}	
				} 
				return $record;
			}
		/*END GET RECORD FUNCTION GetRecord()*/	

		/*BEGIN PAGINATION FUNCTION */
			public function PagiNation($tablename,$primarykey)
			{
				

				/*
					REQUIREMENT : 
						$tablename : Table Name where data will be inserted
						$primarykey : primary key of the table

					RETURN : display the pagination number in list 
				*/

				if(TABLE_PREFIX!="")
				{
					$tablename = TABLE_PREFIX.$tablename;
				}	

				echo '<div class="row">';	
					echo '<div class="col-md-8">';

						$totalrecord_data = mysql_fetch_array(mysql_query("select count(".$primarykey.") as total from ".$tablename."")); 
						if($totalrecord_data['total']>0)	
						{
							$lastpage = ceil($totalrecord_data['total']/$_SESSION['pagerecords_limit']);

							if($lastpage>1)
							{
								echo '<ul class="pagination">';
									if(@$_GET['page']>1)
									{
										echo '<li><a href="'.$_SERVER['PHP_SELF'].'?page=1">&laquo;</a></li>';
									}

									for($a=1;$a<=$lastpage;$a++)
									{	
										if(@$_GET['page']==$a) 
										{
											echo '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$a.'"  style="background:#ddd !important;">'.$a.'</a></li>';
										}
										else
										{
											echo '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$a.'">'.$a.'</a></li>';
										}

									}
									
									if(@$_GET['page']<$lastpage)
									{
										echo '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$lastpage.'">&raquo;</a></li>';
									}
								echo '</ul>';
							}	
						}

					echo '</div>';		

					echo '<div class="col-md-3">';
						if($totalrecord_data['total']>20)
						{
							echo '<ul class="pagination">';
								echo "<li><a>Records/Page : </a></li>";
								$record_array = array(20,50,100,200);
								foreach ($record_array as $key => $value)
								{
									if($_SESSION['pagerecords_limit']==$value) 
										{$activerecord='style="background:#ddd !important;"';}
									else 
										{$activerecord="";}

									echo '<li><a href="'.$_SERVER['PHP_SELF'].'?record='.$value.'" '.$activerecord.'>'.$value.'</a></li>';	
								}
							echo '</ul>';
						}
					echo '</div>';
				echo '</div>';				
			}
		/*END PAGINATION FUNCTION : PagiNation() */	

		/*BEGIN UPDATE RECORD FUNCTION */
			public function UpdateRecord($tablename,array $values,$where="")
			{

				/*
					REQUIREMENT : 
						$tablename : Table Name where data will be inserted
						$values :  	array 
									field_1 => value_1,field_2 => value_2,field_3 => value_3,field_n => value_n

									field names and values which will be updated.
						$where : 	Where condition in string : id = 1, id =1 and status=1

					RETURN : number of updated records 
				*/

				if(TABLE_PREFIX!="")
				{
					$tablename = TABLE_PREFIX.$tablename;
				}	

				if(!empty($values))
				{
					$query_string = "update ".$tablename." set ";

					foreach($values as $key=>$value)
					{
						$query_string.=$key." = '".addslashes($value)."' , ";	
					}
					
					$query_string = trim($query_string," , ");

					if($where!="")
					{
						$query_string.=" where ".$where;
					}

					/* TO CHECK QUERY REMOVE ENABLE BELOW CODE */
					//echo $query_string;exit;

					mysql_query($query_string) or die(mysql_error());
					
				}

				return mysql_affected_rows();
			}
		/*END UPDATE RECORD FUNCTION : UpdateRecord()*/	

		/*BEGIN DELETE RECORD FUNCTION*/	
			public function DeleteRecord($tablename, $where, $limit=0)
			{
				/*
					REQUIREMENT : 
						$tablename : Table Name where data will be inserted
						$where : 	Where condition in string : id = 1, id =1 and status=1

					RETURN : number of deleted records 
				*/

				if(TABLE_PREFIX!="")
				{
					$tablename = TABLE_PREFIX.$tablename;
				}	

				$query_string = "delete from ".$tablename." ";

				if($where!="")
				{
					$query_string.=" where ".$where;
				}

				if($limit>0)
				{
					$query_string.=" limit ".$limit;	
				}

				/* TO CHECK QUERY REMOVE ENABLE BELOW CODE */
				//echo $query_string;exit;

				mysql_query($query_string) or die(mysql_error());

				return mysql_affected_rows();
			}
		/*END DELETE RECORD FUNCTION : DeleteRecord() */		

		/*BEGIN GET CUSTOM FUNCTION */
			public function GetCustom($query_string)
			{
				/*
					REQUIREMENT : 
							$query = query string as per your requirements
				*/	

				$query = mysql_query($query_string) or die(mysql_error());
				$record_array = array();
				while($data=mysql_fetch_assoc($query))
				{
					$record_array[] = $data;
				}

				return $record_array;
			}
		/*END GET CUSTOM FUNCTION : GetCustom() */	

	/*END DATABASE BASED NORMAL FUNCTION */

	/*BEGIN FILE MANAGEMENT FUNCTOIN */
		/*BEGIN UPLOAD FILE FUNCTION */
			public function UploadFile($files,array $array)
			{
				$uploaded_files = array();
				if(isset($files) && $files['name']!="")
				{
					//CHANGING PERMISSION OF THE DIRECTORY
					@chmod($array['uploadpath'], 0755);

					if($array['limit']==0 || $array['limit']>@count($files['name']))
					{
						$array['limit']=@count($files['name']);
					}

					$allowedfiletypes = $array['filetype'];
					$max_size = $array['maxsize']*1000;	//in KB

					for($a=0;$a<$array['limit'];$a++)
					{						

						$filename="";
						if($array['limit']>1)
						{
							$currentfile_extension = end(explode(".",$files['name'][$a]));
							if(in_array(strtolower($currentfile_extension),$allowedfiletypes))
							{
								$filename = date("YmdHis").rand(1000,9999).".".$currentfile_extension;

								if($files['size'][$a]<$max_size)		
								{	
									if(@move_uploaded_file($files['tmp_name'][$a], $array['uploadpath'].$filename))
									{
										$uploaded_files[]=$filename;

										//CHANGIN FILE PERMISSION
										@chmod($array['uploadpath'].$filename, 0755);
									}
								}
							}
						}
						else
						{
							$currentfile_extension = end(explode(".",$files['name']));
							if(in_array(strtolower($currentfile_extension),$allowedfiletypes))
							{
								$filename = date("YmdHis").rand(1000,9999).".".$currentfile_extension;

								if($files['size'][$a]<$max_size)		
								{	
									if(@move_uploaded_file($files['tmp_name'], $array['uploadpath'].$filename))
									{
										$uploaded_files[]=$filename;

										//CHANGIN FILE PERMISSION
										@chmod($array['uploadpath'].$filename, 0755);
									}
								}
							}
						}
					}
				}

				return $uploaded_files;
			}
		/*END UPLOAD FILE FUNCTION : UploadFile() */

		/*BEGIN DELETE FILE FUNCTION */
			public function DeleteFile(array $array)
			{
				foreach ($array['files'] as $key => $value) 
				{
					@unlink($array['uploadpath'].$value);
				}
			}
		/*DELETE FILE FUNCTION*/

	/*END FILE MANAGEMENT FUNCTION */

	/*BEGIN DATE DIFFERENCE FUNCTION*/
		public function DateDifference($date1,$date2)
		{
			$difference = abs(strtotime($date1)-strtotime($date2));
	        $difference_array['hours'] = ceil($difference/(60*60));
	        $difference_array['days'] = floor($difference_array['hours']/24);
	        $difference_array['extra_hours'] = abs($difference_array['hours']%24);

	        return $difference_array;
		}
	/*END DATE DIFFERENCE FUNCTION : DateDifference()*/

}

?>