<?php
	/**********
		name: viewInfo
		version: 1.0
		programmer: mahdi khanzadi
		country: iran republic
		date: 2016 (1396/1/1 Happy New Iranian Year)
		web page: http://tarhche.ir
		phone: 09373620353
		email: khanzadimahdi@gmail.com
		description: just made with love of IRAN, enjoy it :-)
	***********/
	
	//create a namespace for our script 
	namespace viewinfo;
	//import php data object (PDO) namespace
	use \PDO;
	//create a class for counter
	class viewinfo{
		
		//our database info for using in our script
		const database_hostname='localhost';
		const database_username='root';
		const database_password='';
		const database_name='shahrdary';

		//our database connection info
		public $connection=null;
		//our prepared statement
		public $statement=null;
		//our query result
		public $result=null;
		//our database error flag
		public $db_error=false;

		public function __construct(){ //initial state = connecting to database + set some variables
			//create our database connection
			try{
				//this dns is for connecting MariaDB (mysql)
				$dns='mysql:hostname='.self::database_hostname.';dbname='.self::database_name;
				$this->connection=new PDO($dns,self::database_username,self::database_password);
				if(empty($this->connection)){
					throw new Exception("database connection error");
				}else{
					//set error level for database connection
					$this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					//set database charset for results
					$this->connection->exec('set names utf8');
				}
			}catch(Exception $e){
				//set database error flag
				$this->db_error=true;	
				//show errors
				echo $e->getMessage();
				print_r($this->connection->errorInfo());
			}
		}

		private function whatIsIP(){
	    	$ipaddress = null;
	    	if (!empty($_SERVER['HTTP_CLIENT_IP']))
	        	$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	    	else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
			else if(!empty($_SERVER['HTTP_X_FORWARDED']))
	    	    $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	    	else if(!empty($_SERVER['HTTP_FORWARDED_FOR']))
	        	$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	    	else if(!empty($_SERVER['HTTP_FORWARDED']))
	        	$ipaddress = $_SERVER['HTTP_FORWARDED'];
	    	else if(!empty($_SERVER['REMOTE_ADDR']))
		        $ipaddress = $_SERVER['REMOTE_ADDR'];
	    	return $ipaddress;			
		}

		private function createseentime(){
			return time();
		}

		public function set_view_ByID($id){ //set view into database
			$ip=$this->whatIsIP();
			if($this->get_view_ByIDandIP($id,$ip)){
				return 0;//this ip and id has been saved before
			}
			$query="insert into views (ip,id,seentime) values (?,?,?)";
			$this->statement=$this->connection->prepare($query);
			$this->statement->bindValue(1,$ip,PDO::PARAM_INT);
			$this->statement->bindValue(2,$id,PDO::PARAM_INT);
			$this->statement->bindValue(3,$this->createseentime(),PDO::PARAM_STR);
			$this->statement->execute();
			if($this->statement->rowCount()<=0){
				//cant save data into database
			}else{
				return 1;//done successfully
			}
		}

		public function get_view_ByID($id){ //get view array from database
			$query="select * from views where id=? order by inc_id desc";
			$this->statement=$this->connection->prepare($query);
			$this->statement->bindValue(1,$id,PDO::PARAM_INT);
			$this->statement->execute();
			if($this->statement->rowCount()<=0){
				//there is no data for this id
			}else{
				$this->result=$this->statement->fetchAll();
				return $this->result;
			}
		}

		public function get_view_ByIDandIP($id,$ip){ //get view array from database by its id and ip
			$query="select * from views where id=? and ip=?";
			$this->statement=$this->connection->prepare($query);
			$this->statement->bindValue(1,$id,PDO::PARAM_INT);
			$this->statement->bindValue(2,$ip,PDO::PARAM_STR);
			$this->statement->execute();
			if($this->statement->rowCount()<=0){
				//there is no data for this id
			}else{
				$this->result=$this->statement->fetchAll();
				return $this->result;
			}
		}


		public function get_count_ByID($id){ // get number of views
			$query="select count(*) as cnt from views where id=?";
			$this->statement=$this->connection->prepare($query);
			$this->statement->bindValue(1,$id);
			$this->statement->execute();
			if($this->statement->rowCount()<=0){
				//there is no data for this id
			}else{
				$this->result=$this->statement->fetchAll();
				return !empty($this->result[0]['cnt']) ? $this->result[0]['cnt'] : 0;
			}
		}

		public function get_lastSeenTime_ByID($id){ //get lastseen time
			$query="select * from views where id=? order by inc_id desc limit 1";
			$this->statement=$this->connection->prepare($query);
			$this->statement->bindValue(1,$id,PDO::PARAM_INT);
			$this->statement->execute();
			if($this->statement->rowCount()<=0){
				//there is no data for this id
			}else{
				$this->result=$this->statement->fetchAll();
				return !empty($this->result[0]['seentime']) ? $this->result[0]['seentime'] : null;
			}
		}

		public function get_lastSeenIP_ByID($id){ //get lastseen user ip
			$query="select * from views where id=? order by inc_id desc limit 1";
			$this->statement=$this->connection->prepare($query);
			$this->statement->bindValue(1,$id,PDO::PARAM_INT);
			$this->statement->execute();
			if($this->statement->rowCount()<=0){
				//there is no data for this id
			}else{
				$this->result=$this->statement->fetchAll();
				return !empty($this->result[0]['ip']) ? $this->result[0]['ip'] : null;
			}
		}

		public function __desctruct(){ //disconnect from database and clear its data
			//end the database connection
			$this->connection=null;
			unset($this->connection);

		}
	}

	/*How to use*/
	/*at first include viewinfo.php in your php page*/
	/*
	 $viewinfo=new \viewinfo\viewinfo();
	 echo $viewinfo->set_view_ByID(2);//save view for an id
	 print_r($viewinfo->get_view_ByID(1));//shows all view of an id
	 echo $viewinfo->get_count_ByID(1);//show view count of an id
	 echo $viewinfo->get_lastSeenTime_ByID(1);//show last seen of an id
	 echo $viewinfo->get_lastSeenIP_ByID(1); // show last ip has seen an id
	*/