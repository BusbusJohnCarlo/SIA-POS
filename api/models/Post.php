<?php


class Post{
    protected $gm, $pdo, $get;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
        $this->gm = new GlobalMethods($pdo);
        $this->get = new Get($pdo);
    }

// ADD PRODUCT


public function checkPreOrderItem($product_name, $existingItem)
{

			if($product_name===$existingItem){
				return true;
			}
			return false;
}


public function addPreOrderNew($dt)
{
  
    $payload = $dt;
    $product_name = $dt->product_name;
  
  



    $sql = "SELECT * FROM pos_order_tb WHERE product_name='$product_name' LIMIT 1";
    $res = $this->gm->generalQuery($sql, "Failed");
    if($res['code'] == 200) {
        if($this->checkPreOrderItem($product_name, $res['data'][0]['product_name'])) {
   
            $newQuantity = $dt->quantity + $res['data'][0]['quantity'];
            $newPrice = $dt->price + $res['data'][0]['price'];

            $sql1=" UPDATE `pos_order_tb` 
            SET 
            `quantity` = '$newQuantity',
            `price` = '$newPrice'
            WHERE 
            `product_name` = '$product_name';
            
            "; 
           
            

            $res1 = $this->gm->generalQuery($sql1, "");

            

        if ($res1['code'] != 200) {
 
            $code = 200;
            $payload = $res1;
            $remarks = "success";
            $message = $res1;

        } 

       
           
           
        } else {
            $payload = null; 
            $remarks = "failed"; 
            $message = $res['errmsg'];

        }
    }	else {

    $res = $this->addPreOrder($dt);

        $code = 200;
        $payload = $res;
        $remarks = "success";
        $message = "Successfully retrieved data";

    }
    return $this->gm->sendPayload($payload, $remarks, $message, $code);
    }







public function addPreOrder($data) {

    $code = 401;
    $payload = null;
    $remarks = "failed";
    $message = "Unable to retrieve data";


    $res = $this->gm->insert('pos_order_tb', $data);

    if($res['code']==200) {
        $code = 200;
        $payload = $res;
        $remarks = "success";
        $message = "Successfully retrieved data";
        
    }
    return $this->gm->sendPayload($payload, $remarks, $message, $code);
  
}
//update
public function updatePreOrder($data) {

    $code = 401;
    $payload = null;
    $remarks = "failed";
    $message = "Unable to retrieve data";
    $orderInfo = $data->orderInfo;

    $res = $this->gm->edit('pos_order_tb', $orderInfo);

    if($res['code']==200) {
        $code = 200;
        $payload = $res['data'];
        $remarks = "success";
        $message = "Successfully retrieved data";
        
    }
    return $this->gm->sendPayload($payload, $remarks, $message, $code);
  
}
//ADD TO CART
    public function addOrder($data) {

        $code = 401;
        $payload = null;
        $remarks = "failed";
        $message = "Unable to retrieve data";
        $cardInfo = $data->cardInfo;

        $res = $this->gm->insert('pos_preorder_tb', $cardInfo);

        if($res['code']==200) {
            $code = 200;
            $payload = $res['data'];
            $remarks = "success";
            $message = "Successfully retrieved data";
            
        }
        return $this->gm->sendPayload($payload, $remarks, $message, $code);
      
    }
    public function addProduct($data) {

        $code = 401;
        $payload = null;
        $remarks = "failed";
        $message = "Unable to retrieve data";
        $productInfo = $data->productInfo;

        $res = $this->gm->insert('menu_tb', $productInfo);

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
        $prodID = $data->prodID;
         $res = $this->gm->delete('pos_preorder_tb', $data, "prodID = '$prodID'"); if ($res['code'] == 200) 
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

        public function delPre($d) { 
            $data = $d; 
            $order_ID = $data->order_ID;
             $res = $this->gm->delete('pos_order_tb', $data, "order_ID = '$order_ID'"); if ($res['code'] == 200) 
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
