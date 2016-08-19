<?php
class search
{
	public function guerygen ($table,$array_holder){
		
		$q_Temp="";
		$temp_key='NULL';
		$q_Temp.="select * from $table ";
		//print_r($array_holder);
		foreach ($array_holder as $key => $value){
			
			if ($value != '' && $value != 'NULL'){
				
				if($temp_key != 'NULL'){
					$q_Temp .= " and ";
				}
				
				if($temp_key == 'NULL'){
					$q_Temp .= " where ";
				}
				$q_Temp .= " $key = '$value'";
				$temp_key= "yes"; // MOVED IT FORM BELOW THE IF SENTENCE TO WITHIN THE IF SENTENCE
			}
		}
		
		return $q_Temp;
	}
}
?>