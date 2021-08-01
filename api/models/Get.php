<?php


class Get{
    protected $gm, $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
        $this->gm = new GlobalMethods($pdo);
    }

	public function pullOrder ($d) {     
	   $sql = "SELECT * FROM pos_preorder_tb";            
	       
	   $res = $this->gm->generalQuery($sql, "No records found");        
	   if ($res['code'] == 200) {            
		   $payload = $res['data'];            
		   $remarks = "success";            
		   $message = "Successfully retrieved requested data";        
		} 
		else {            
			$payload = null;            
			$remarks = "failed";            
			$message = $res['errmsg'];       
		 }        
			return $this->gm->sendPayload($payload, $remarks, $message, $res['code']);  
	  }
	  public function pullPre ($d) {     
		$sql = "SELECT * FROM pos_order_tb";            
			
		$res = $this->gm->generalQuery($sql, "No records found");        
		if ($res['code'] == 200) {            
			$payload = $res['data'];            
			$remarks = "success";            
			$message = "Successfully retrieved requested data";        
		 } 
		 else {            
			 $payload = null;            
			 $remarks = "failed";            
			 $message = $res['errmsg'];       
		  }        
			 return $this->gm->sendPayload($payload, $remarks, $message, $res['code']);  
	   }
	   public function pullProduct ($d) {     
		$sql = "SELECT * FROM menu_tb";            
			
		$res = $this->gm->generalQuery($sql, "No records found");        
		if ($res['code'] == 200) {            
			$payload = $res['data'];            
			$remarks = "success";            
			$message = "Successfully retrieved requested data";        
		 } 
		 else {            
			 $payload = null;            
			 $remarks = "failed";            
			 $message = $res['errmsg'];       
		  }        
			 return $this->gm->sendPayload($payload, $remarks, $message, $res['code']);  
	   }
	 }
	
	
	
?>