<?php

/*
* Class for array search in php using wild card, case sensitive, exact word match.
*  
* When it comes to array search in php by exact key or value or wild card search and multidimensional 
* associative array search recursively , php developers doesn't have much choice by default but to write 
* your own custom code to fulfill that. For this, they may have to resort to using many functions like 
* in_array, array_search, php foreeach loop, php substr and lots of other functions but none of them 
* come handy when you need advanced associative multidimensional array search in php for keys and values. 
* Sometimes php developers may have connect to sql database repeatedly and issue sql query repeatedly 
* to find required records. But after using this class, they can simply fetch all records at once 
* and then filter required records using advanced php array search class.

* Here are key benefits:
* Search multidimensional associative array in php using wild card '%'. You can find any keys or values 
* of an array which starts or ends which some phrase or exact phrase you would like to search for.

* This means:
* 1. Search array in php recursively by key only using exact phrase or wild card %
* 2. Search array in php recursively by value only using exact phrase or wild card %
* 3. Search array in php recursively by values or keys using exact phrase or wild card %
* 4. Search array in php recursively - case sensitive and insensitive search

* Copyright (c) 2012, Alpesh Panchal
* All right reserved
* * 
* Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following 
* conditions are met:
* 
*  - Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
*  - Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer 
*    in the documentation and/or other materials provided with the distribution.
* 
* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, 
* BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT 
* SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL 
* DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
* INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE 
* OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*
* Author: Alpesh Panchal
* Website: http://www.webappmaster.com
*/

class array_search {
    
    private function get_like_type( $search_like_str ) {
                    
        $search_like_str_arr = explode('%', $search_like_str);
        
        if(count($search_like_str_arr) == 3) {
            
            if($search_like_str_arr[1] != '%') {
                
                return 'like';
                
            } else {
                
                return false;
            }
            
        }
         
        if(count($search_like_str_arr) == 2) {
            
            if($search_like_str_arr[0] == '') {
                
                return 'endwith';
                
            } else if($search_like_str_arr[1] == '') {
                
                return 'startwith';
                
            } else {
                
                return false;
            }
            
        }

        return false;
        
    }

    private function is_end_with($str, $find, $case_sensitive=false) {
        //$str = 'how how are you?';
        //$find = 'you?';
        $sub_str = substr($str, 0, strlen($str)-strlen( $find ));  
        
        $str_end = substr($str, strlen($sub_str) );
        
        if($case_sensitive == false) {
            if( strcasecmp(strtolower($str_end) ,strtolower($find)) == 0 )
                return true;
        }
        
        if($case_sensitive == true) {
            if( strcmp($str_end ,$find) == 0 )
                return true;
        }
        
        return false;    
        
    }
    //echo is_end_with('#dfdfkB', 'b');
    //die;
    //$search_like_result = array();
    
    private function search_value_recursively( $key, $value, $search_like_str, $original_key_value, $like_type, $case_sensitive=false ) {

       global $search_like_result;
       
       if(is_array($value) && count($value) > 0 ) { 

           foreach ( $value as $sub_value ) {
                 if(is_array($sub_value) && count($sub_value) > 0) {
                    $this->search_value_recursively($key, $sub_value, $search_like_str, $original_key_value, $like_type, $case_sensitive);
                } else {
                    if($case_sensitive == false) {
                        if( $like_type == false ) {
                            if(strcasecmp($sub_value, $search_like_str) === 0 ) {
                                if(!isset($search_like_result[$original_key_value[0]]))
                                    $search_like_result[$original_key_value[0]] = $original_key_value[1];    
                            } 
                        }
                    } else {
                        if( $like_type == false ) {
                            if(strcmp($sub_value, $search_like_str) === 0 ) {
                                if(!isset($search_like_result[$original_key_value[0]]))
                                    $search_like_result[$original_key_value[0]] = $original_key_value[1];
                            } 
                        }    
                    }
                    
                    
                    if($case_sensitive == false) {
                        if( $like_type == 'like' ) { 
                            if(stripos($sub_value, $search_like_str) !== false) {
                                
                                if(!isset($search_like_result[$original_key_value[0]])) {
                                    $search_like_result[$original_key_value[0]] = $original_key_value[1]; 
                                }        
                            }
                        }
                    } else {
                        if( $like_type == 'like' ) { 
                            if(strpos($sub_value, $search_like_str) !== false) {
                                
                                if(!isset($search_like_result[$original_key_value[0]])) {
                                    $search_like_result[$original_key_value[0]] = $original_key_value[1]; 
                                }        
                            }
                        }    
                    }
                    
                    
                    if($case_sensitive == false) {
                        if( $like_type == 'startwith' ) {
                           
                           if((stripos($sub_value, $search_like_str) !== false) && ( stripos($sub_value, $search_like_str) == 0 ) ) {
                                
                               if(!isset($search_like_result[$original_key_value[0]]))
                                    $search_like_result[$original_key_value[0]] = $original_key_value[1];   
                           }
                            
                        }
                    } else {
                        if( $like_type == 'startwith' ) {
                           
                           if((strpos($sub_value, $search_like_str) !== false) && ( strpos($sub_value, $search_like_str) == 0 ) ) {
                                
                               if(!isset($search_like_result[$original_key_value[0]]))
                                    $search_like_result[$original_key_value[0]] = $original_key_value[1];   
                           }
                            
                        }   
                        
                    }
                    
                    if($case_sensitive == false) {
                        if( $like_type == 'endwith' ) { 
                            
                           if((stripos($sub_value, $search_like_str) !== false) && ( $this->is_end_with($sub_value, $search_like_str, false) == true ) ) {
                               if(!isset($search_like_result[$original_key_value[0]]))
                                    $search_like_result[$original_key_value[0]] = $original_key_value[1];      
                           }
                            
                        }
                    } else {
                        if( $like_type == 'endwith' ) { 
                            
                           if((strpos($sub_value, $search_like_str) !== false) && ( $this->is_end_with($sub_value, $search_like_str, true) == true ) ) {
                               if(!isset($search_like_result[$original_key_value[0]]))
                                    $search_like_result[$original_key_value[0]] = $original_key_value[1];      
                           }
                            
                        }    
                    }

                    
                }

           }
       }
         
    }
    
    private function search_key_recursively($key, $value, $search_like_str, $original_key_value, $like_type, $case_sensitive=false) {
       //if(!is_array($value) || (is_array($value) && count($value) == 0 ) ) return false;
        
       global $search_like_result;
       //print_r($value);
       //return $search_like_result;
       if(is_array($value) && count($value) > 0 ) {
           foreach ( $value as $sub_key => $sub_value ) {
                 if(is_array($sub_value) && count($sub_value) > 0) {
                    //echo $sub_key . '==>' . $search_like_str."<br />";
                    $this->search_key_recursively($sub_key, $sub_value, $search_like_str, $original_key_value, $like_type, $case_sensitive);
                } else {
                    //echo $sub_key . '==>' . $search_like_str."<br />";
                    if($like_type == false) {
                        if($case_sensitive == false) {
                            if(strcasecmp($key, $search_like_str) === 0 ) {
                                if(!isset($search_like_result[$key]))
                                    $search_like_result[$original_key_value[0]] = $original_key_value[1]; 
                            }
                        } else {
                            if(strcmp($key, $search_like_str) === 0 ) {
                                if(!isset($search_like_result[$key]))
                                    $search_like_result[$original_key_value[0]] = $original_key_value[1]; 
                            }     
                        }
 
                    }
                    if($like_type == 'like') {
                        if($case_sensitive == false) { 
                            if(stripos($key, $search_like_str) !== false) {
                                if(!isset($search_like_result[$key])) {
                                    //$search_like_result[$key] = $value;
                                    $search_like_result[$original_key_value[0]] = $original_key_value[1];
                                }        
                            }
                        } else {
                            if(strpos($key, $search_like_str) !== false) {
                                if(!isset($search_like_result[$key])) {
                                    //$search_like_result[$key] = $value;
                                    $search_like_result[$original_key_value[0]] = $original_key_value[1];
                                }        
                            }   
                        }
                    }
                    
                    if($like_type == 'startwith') { 
                        //problem in array key search
                        if($case_sensitive == false) {
                            if((stripos($key, $search_like_str) !== false) && ( stripos($key, $search_like_str) == 0) )  {
                                if(!isset($search_like_result[$key]))
                                    $search_like_result[$original_key_value[0]] = $original_key_value[1];   
                            }
                        } else {
                            if((strpos($key, $search_like_str) !== false) && ( strpos($key, $search_like_str) == 0) )  {
                                if(!isset($search_like_result[$key]))
                                    $search_like_result[$original_key_value[0]] = $original_key_value[1];   
                            }    
                        }
                    }
                    
                    if($like_type == 'endwith') {
                        if($case_sensitive == false) { 
                            if((stripos($key, $search_like_str) !== false) && ( $this->is_end_with($key, $search_like_str, false) == true)) {
                               if(!isset($search_like_result[$key]))
                                    $search_like_result[$original_key_value[0]] = $original_key_value[1];   
                            }
                        } else {
                            if((strpos($key, $search_like_str) !== false) && ( $this->is_end_with($key, $search_like_str, true) == true)) {
                               if(!isset($search_like_result[$key]))
                                    $search_like_result[$original_key_value[0]] = $original_key_value[1];   
                            }    
                        }
                    }   
                     
                }

           }
       } 
         
    }
    
    private function get_filter_like_items($value, $key, $mixed) {

       if(!isset($mixed['key_and_or_value'])) return false;
       if(!isset($mixed['search_like_str'])) return false;
            
       global $search_like_result;
       
       $like_type = $this->get_like_type($mixed['search_like_str']);
       
       if( $like_type == false ) {
        
           $mixed['search_like_str'] = str_replace('%', '', $mixed['search_like_str']);
           if( ($mixed['key_and_or_value'] == 'key' || $mixed['key_and_or_value'] == 'both') ) {     
               
               if(is_array($value) && count($value)>0) {
                    $original_key_value = array($key,$value);
                    
                    $this->search_key_recursively($key, $value, $mixed['search_like_str'], $original_key_value, $like_type, $mixed['case_sensitive']);
                    

               } else { 
               
                   if($mixed['case_sensitive'] == false) {
                       if(strcasecmp($key, $mixed['search_like_str']) === 0 ) {
                            if(!isset($search_like_result[$key]))
                                $search_like_result[$key] = $value;
                       }    
                   } else {
                       if(strcmp($key, $mixed['search_like_str']) === 0 ) {
                            if(!isset($search_like_result[$key]))
                                $search_like_result[$key] = $value;
                       }     
                   }

                   
                   
               }
           }
           
           if( ($mixed['key_and_or_value'] == 'value' || $mixed['key_and_or_value'] == 'both') ) {     
               if(is_array($value) && count($value)>0) {
                   $original_key_value = array($key,$value); 
                   
                   $this->search_value_recursively($key, $value, $mixed['search_like_str'], $original_key_value, $like_type, $mixed['case_sensitive']);
                   
       
               } else {
                    if($mixed['case_sensitive'] == false) {    
                        if(strcasecmp($value, $mixed['search_like_str']) === 0 ) {
                            if(!isset($search_like_result[$key]))
                                $search_like_result[$key] = $value;    
                        }
                    } else {
                        if(strcmp($value, $mixed['search_like_str']) === 0 ) {
                            if(!isset($search_like_result[$key]))
                                $search_like_result[$key] = $value;    
                        }   
                    } 
               }

           } 
           
       }
        
       if($like_type == 'like') {
           
           $mixed['search_like_str'] = str_replace('%', '', $mixed['search_like_str']);
           if( ($mixed['key_and_or_value'] == 'key' || $mixed['key_and_or_value'] == 'both') ) {     
               
               if(is_array($value) && count($value)>0) {
                    $original_key_value = array($key,$value);
                    
                    $this->search_key_recursively($key, $value, $mixed['search_like_str'], $original_key_value, $like_type, $mixed['case_sensitive']);
                    
       
               } else {
                    if($mixed['case_sensitive'] == false) { 
                        if(stripos($key, $mixed['search_like_str']) !== false) {
                            if(!isset($search_like_result[$key]))
                                $search_like_result[$key] = $value;
                        }
                    } else {
                        if(strpos($key, $mixed['search_like_str']) !== false) {
                            if(!isset($search_like_result[$key]))
                                $search_like_result[$key] = $value;
                        }    
                    }
               }
           }
           
           if( ($mixed['key_and_or_value'] == 'value' || $mixed['key_and_or_value'] == 'both') ) {     
               if(is_array($value) && count($value)>0) {
                    $original_key_value = array($key,$value); 
                    $this->search_value_recursively($key, $value, $mixed['search_like_str'], $original_key_value, $like_type, $mixed['case_sensitive']);
       
               } else {
                    if($mixed['case_sensitive'] == false) {  
                        if(stripos($value, $mixed['search_like_str']) !== false) {
                            if(!isset($search_like_result[$key]))
                                $search_like_result[$key] = $value;    
                        }
                    } else {
                        if(strpos($value, $mixed['search_like_str']) !== false) {
                            if(!isset($search_like_result[$key]))
                                $search_like_result[$key] = $value;    
                        }    
                    } 
               }

           }
       }
       
       if($like_type == 'startwith') {
           $mixed['search_like_str'] = str_replace('%', '', $mixed['search_like_str']);
           if( ($mixed['key_and_or_value'] == 'key' || $mixed['key_and_or_value'] == 'both') ) {     

               if(is_array($value) && count($value)>0) {
                    $original_key_value = array($key,$value);
                    $this->search_key_recursively($key, $value, $mixed['search_like_str'], $original_key_value, $like_type, $mixed['case_sensitive']);
               } else {
                    if($mixed['case_sensitive'] == false) { 
                        if((stripos($key, $mixed['search_like_str']) !== false) && ( stripos($key, $mixed['search_like_str']) == 0) )  {
                            if(!isset($search_like_result[$key]))
                                $search_like_result[$key] = $value;    
                        }
                    } else {
                        if((strpos($key, $mixed['search_like_str']) !== false) && ( strpos($key, $mixed['search_like_str']) == 0) )  {
                            if(!isset($search_like_result[$key]))
                                $search_like_result[$key] = $value;    
                        }
                    }
               }
           }
           
           if( ($mixed['key_and_or_value'] == 'value' || $mixed['key_and_or_value'] == 'both') ) {     
               
               if(is_array($value) && count($value)>0) {
                    $original_key_value = array($key,$value); 
                    $this->search_value_recursively($key, $value, $mixed['search_like_str'],$original_key_value, $like_type, $mixed['case_sensitive']); 
                   
               } else {  
                   if($mixed['case_sensitive'] == false) {
                       if((stripos($value, $mixed['search_like_str']) !== false) && ( stripos($value, $mixed['search_like_str']) == 0 ) ) {
                           if(!isset($search_like_result[$key]))
                                $search_like_result[$key] = $value;    
                       }
                   } else {
                       if((strpos($value, $mixed['search_like_str']) !== false) && ( strpos($value, $mixed['search_like_str']) == 0 ) ) {
                           if(!isset($search_like_result[$key]))
                                $search_like_result[$key] = $value;    
                       }    
                   }
               }
           }
       }
       
       if($like_type == 'endwith') {
           
           $mixed['search_like_str'] = str_replace('%', '', $mixed['search_like_str']);
           if( ($mixed['key_and_or_value'] == 'key' || $mixed['key_and_or_value'] == 'both') ) {     
               
               if(is_array($value) && count($value)>0) {
                    $original_key_value = array($key,$value);
                    $this->search_key_recursively($key, $value, $mixed['search_like_str'], $original_key_value, $like_type, $mixed['case_sensitive']);
               } else {
                   if($mixed['case_sensitive'] == false) { 
                       if((stripos($key, $mixed['search_like_str']) !== false) && ( $this->is_end_with($key, $mixed['search_like_str'], false) == true) )  {
                           if(!isset($search_like_result[$key]))
                                $search_like_result[$key] = $value;    
                       }
                   } else {
                       if((strpos($key, $mixed['search_like_str']) !== false) && ( $this->is_end_with($key, $mixed['search_like_str'], true) == true) )  {
                           if(!isset($search_like_result[$key]))
                                $search_like_result[$key] = $value;    
                       }    
                   }
               }
           }
           
           if( ($mixed['key_and_or_value'] == 'value' || $mixed['key_and_or_value'] == 'both') ) {     
               if(is_array($value) && count($value)>0) {
                    $original_key_value = array($key,$value); 
                    $this->search_value_recursively($key, $value, $mixed['search_like_str'], $original_key_value, $like_type, $mixed['case_sensitive']); 
                   
               } else {
                    if($mixed['case_sensitive'] == false) {   
                        if((stripos($value, $mixed['search_like_str']) !== false) && ( $this->is_end_with($value, $mixed['search_like_str'], false) == true ) ) {
                           if(!isset($search_like_result[$key]))
                                $search_like_result[$key] = $value;    
                        }
                    } else {
                        if((strpos($value, $mixed['search_like_str']) !== false) && ( $this->is_end_with($value, $mixed['search_like_str'], true) == true ) ) {
                           if(!isset($search_like_result[$key]))
                                $search_like_result[$key] = $value;    
                        }   
                    }
               }
           }
       }
       
       return true;

    }
    
    /*
    * array_like
    * 
    * Seaches an array into both keys and/or values for a given words using wild card and case sensitive flag
    * 
    * @param    array      array - an array to search in
    * @param    string     search_like_str - enter exact word to search or with wild card e.g. %word% or word% or %word
    * @param    string     key_and_or_value - value, key, both
    * @param    boolean    case_sensitive - true or false
    * @return main item of an array containing searched word either into keys or values 
    * 
    */
    
    function array_like($array, $search_like_str, $key_and_or_value='value', $case_sensitive = false) {
        
        $mixed = array('search_like_str'=>$search_like_str, 'key_and_or_value' => $key_and_or_value, 'case_sensitive' => $case_sensitive);
        
        global $search_like_result;
         
        array_walk($array, array($this,'get_filter_like_items'), $mixed);
        
        $result = $search_like_result;
        
        unset( $GLOBALS['search_like_result'] );
          
        return $result;
                
    } 
    

}



    
?>
