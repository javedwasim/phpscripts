<?php
	/**
	 * This class returns a DHTML code to enable some text to be edited on the fly (edit in place)
	 * This class is compatible for PHP 4.x and PHP 5.x
	 * 
	 * Version 1 You can create grid like structure and edit on the fly
	 * The grid is automaticaly updated after few seconds	 * 
	 *
	 *
	 * @version 1
	 * @author Rochak Chauhan
	 * 
	 * @uses Prototype library for AJAX
	 * 
	 * @todo It generated javascript "EXCEPTION" warnings... but does not effect the functionality. Working on that. 
	 * 		The whole code is not totaly OOPS Oriented in order to make it easier to understand.
	 */
	class AjaxGrid {
		
		var $codeToBeEdited = '';
		var $styleSheetClassName = '';
				
		/**
		 * Constructor function
		 * 
		 * @param string $codeToBeEdited
		 * @param string $styleSheetClassName
		 *
		 */
		function AjaxGrid($codeToBeEdited, $styleSheetClassName) {
			
			if ($styleSheetClassName == '') {
				die("INVALID stylesheet class Name");
			}
			
			if ($codeToBeEdited == '') {
				die("Please enter some text");
			}
			
			$this->codeToBeEdited = $codeToBeEdited;
			$this->styleSheetClassName = $styleSheetClassName;
		}
		
		/**
		 * This function returns the AJAX Code, which can be edited in place
		 * 
		 * @param string $idName
		 * 
		 * @return string
		 */
		function getAjaxGridCode($idName) {
			return '<p class="'.$this->styleSheetClassName.'" id="'.$idName.'" title="Click here to edit this text">'.$this->codeToBeEdited.'</p>';
		}
}
?>