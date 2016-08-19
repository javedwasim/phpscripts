<?php
require_once("constants.php");

class Database{

//----------------------------------Varaibles------------------------------------

	private $connection;

	public $LastQuery;

//------------------------------------construct----------------------------------	

	  function __construct() 

	  {

		$this->open_connection();

		$this->magic_quotes_active = get_magic_quotes_gpc();

		$this->real_escape_string_exists = function_exists( "mysql_real_escape_string" );

	  }

//--------------------------------open_connection---------------------------------

	public function open_connection() 

	{
                try{
		$this->connection = mysqli_connect(DB_SERVER,DB_USER,DB_PASS);
                }catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            generateErrorLog("get_ad_hub_preview function",$e->getMessage());
    }
		if (!$this->connection) {

			die("Database connection failed: " . mysqli_error());

		} else {

			  $SelectDatabse = mysqli_select_db( $this->connection, DB_NAME);
                          
			if (!$SelectDatabse) {

				die("Database selection failed: " . mysqli_error());

			}

		}

	}

 public function mysql_prep( $value ){

			$magic_quotes_active = get_magic_quotes_gpc();

			$new_enough_php = function_exists( "mysql_real_escape_string" ); // i.e. PHP >= v4.3.0

			if( $new_enough_php ) { // PHP v4.3.0 or higher

				// undo any magic quote effects so mysql_real_escape_string can do the work

				if( $magic_quotes_active ) { $value = stripslashes( $value ); }

				$value = mysqli_real_escape_string( $this->connection, $value );

			} else { // before PHP v4.3.0

				// if magic quotes aren't already on then add slashes manually

				if( !$magic_quotes_active ) { $value = addslashes( $value ); }

				// if magic quotes are active, then the slashes already exist

			}

			return $value;

		}       
//-------------------------------query-----------------------------------------------

	public function query($SqlQuery) 

	{

			$this->LastQuery = $SqlQuery;

			$result = mysqli_query($this->connection,$SqlQuery);

			$this->confirm_query($result);

			return $result;

		  

       }

//-------------------------------------------------------------------------------------

       public function escape_value( $value ) {

		if( $this->real_escape_string_exists ) { 

			if( $this->magic_quotes_active ) { $value = stripslashes( $value ); }

			$value = mysqli_real_escape_string($this->connection, $value );

		} else { 

			if( !$this->magic_quotes_active ) { $value = addslashes( $value ); }

			// if magic quotes are active, then the slashes already exist

		}

		return $value;

	}

//-------------------------------fetch_array-------------------------------------------		

	 public function fetch_array($ResultSet) 

	  {

		return mysqli_fetch_array($ResultSet);
               

	  }
          public function fetch_object($ResultSet){
              
              return mysqli_fetch_object($ResultSet);
          }

          public function fetch_row($ResultSet) 

                  {

                        return mysqli_fetch_row($ResultSet);

                  }

        public function num_rows($ResultSet){
                return mysqli_num_rows($ResultSet);
        }


//-------------------------------insert_id---------------------------------------------	  

	  public function insert_id() 

	  {

		return mysqli_insert_id($this->connection);

	  }

//-------------------------------affected_rows------------------------------------------	  

	  public function affected_rows() {

		return mysqli_affected_rows($this->connection);

	  }	  

//------------------------------confirm_query-----------------------------------------	

		private function confirm_query($result) 

		{

			if (!$result) {

			$output = "Database query failed: " . mysqli_error() . "<br /><br />";

			$output .= "SQL query: " . $this->LastQuery;

			die( $output );

			}

		}			

//-----------------------------------close_connection------------------------------

	public function close_connection() 

	{

		if(isset($this->connection)) {

			mysqli_close($this->connection);

			unset($this->connection);

		}

	}

//--------------------------------------------------------------------------------

	

}

//--------------------------------------------------------------------------------

$database = new Database();?>