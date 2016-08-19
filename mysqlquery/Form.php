<?php
	/**
	* 
	*/
	class Form
	{
		function Form($arguments=NULL)
		{
			$form="<form ".$arguments." >";
			echo $form;
		}

        function closeForm()
        {
            echo '</form>';
        }
}