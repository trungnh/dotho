<?php
class CLS_MYSQL{
	//var $pro=array("hostname"=>"localhost","username"=>"vnresearch_cms","password"=>"Ab123456","dataname"=>"vnresearch_cms");
	var $pro = array("hostname"=>"localhost","username"=>"root","password"=>"","dataname"=>"db_serverdc");
	var $dbconn=NULL;
	var $result;
	var $lastid;
	function CLS_MYSQL(){
		// set value
		$this->pro["hostname"]=HOSTNAME;
		$this->pro["username"]=DB_USERNAME;
		$this->pro["password"]=DB_PASSWORD;
		$this->pro["dataname"]=DB_DATANAME;
	}
	function connect(){
		// connect mysql server
		$this->dbconn=mysql_connect($this->pro["hostname"],$this->pro["username"],$this->pro["password"],'charset=utf8');
		// if can't connect mysql server
		if(!$this->dbconn){
			echo "Can't connect MySQL Server!";
			return false;
		}
		// if can't select database
		if(@!mysql_select_db($this->pro["dataname"],$this->dbconn))
			return false;
		// if connect success
		return true;
	}
	function disconnect(){
		if(isset($this->dbconn))
		return @mysql_close($this->dbconn);
	}
	// property set value
	function __set($proname,$value)
	{
		if(!isset($this->pro[$proname]))
		{
			echo "$proname isn't member of MySQL Class ";
			return;
		}
		$this->pro[$proname]=$value;
	}
	function __get($proname)
	{
		if(!isset($this->pro[$proname]))
		{
			$this->callmess("$proname isn't member of MySQL Class" );
			return;
		}
		return $this->pro[$proname];
	}
	// function query
	function Query($sql)
	{
		if($this->connect())
		{
			mysql_query('SET character_set_results=utf8');
			mysql_query('SET names=utf8');
			mysql_query('SET character_set_client=utf8');
			mysql_query('SET character_set_connection=utf8');
			mysql_query('SET character_set_results=utf8');
			mysql_query('SET collation_connection=utf8_general_ci');
			$this->result=mysql_query($sql,$this->dbconn);
			@$this->lastid=mysql_insert_id();
			$this->disconnect();
			return $this->result;
		}else{
			return false;
		}
	}
	function LastInsertID(){
		return $this->lastid;
	}
	function FetchArray()
	{
		return (@mysql_fetch_array($this->result));
	}
	function Numrows() { 
         
        return(@mysql_num_rows($this->result)); 
         
    } 
	function callmess($mess){
		echo "$mess";
	}
}
?>