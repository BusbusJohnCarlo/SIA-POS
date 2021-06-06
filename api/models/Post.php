<?php


class Post{
    protected $gm, $pdo, $get;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
        $this->gm = new GlobalMethods($pdo);
        $this->get = new Get($pdo);
    }

// ADD PRODUCT
    
//ADD TO CART
    public function addOrder($data) {

        $code = 401;
        $payload = null;
        $remarks = "failed";
        $message = "Unable to retrieve data";
        $cardInfo = $data->cardInfo;

        $res = $this->gm->insert('tbl_preorder', $cardInfo);

        if($res['code']==200) {
            $code = 200;
            $payload = $res['data'];
            $remarks = "success";
            $message = "Successfully retrieved data";
            
        }
        return $this->gm->sendPayload($payload, $remarks, $message, $code);
      
    }

    public function delOrder($d) { 
        $data = $d; 
        $id = $data->id;
         $res = $this->gm->delete('tbl_preorder', $data, "id = '$id'"); if ($res['code'] == 200) 
         {  
            $payload = $res['data'];            
            $remarks = "success";            
            $message = "Successfully retrieved requested data";        
        } 
        else
         {            
             $payload = null;            
             $remarks = "failed";            
             $message = $res['errmsg'];        
            } 
        }

    //CHECK OUT
    
// //DELETE PRODUCT
//     public function delProduct($data) {

//         $code = 401;
//         $payload = null;
//         $remarks = "failed";
//         $message = "Unable to retrieve data";
//         $conditionString = "pid=".$data->pid;
  
//         $res = $this->gm->delete('tbl_products', $data, $conditionString);

//         if($res['code']==200) {
//             $code = 200;
//             $payload = $res;
//             $remarks = "success";
//             $message = "Successfully retrieved data";
//             return $this->get->pullProducts(null);
//         }
//         return $this->gm->sendPayload($payload, $remarks, $message, $code);
//     }



    


    
}