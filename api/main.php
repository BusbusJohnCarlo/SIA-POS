<?php 
	require_once("./config/Config.php");

	$db = new Connection();
	$pdo = $db->connect();
	$gm = new GlobalMethods($pdo);
	$post = new Post($pdo);
	$get = new Get($pdo);
	$auth = new Auth($pdo);

	if (isset($_REQUEST['request'])) {
		$req = explode('/', rtrim($_REQUEST['request'], '/'));
	} else {
		$req = array("errorcatcher");
	}

	switch($_SERVER['REQUEST_METHOD']) {
		case 'POST':

			

			switch($req[0]) {
				// case 'pre':
				// 	if(count($req)>1){
				// 		echo json_encode($gm->select_pre('pos_order_tb'.$req[0], $req[1]),JSON_PRETTY_PRINT);
				// 	} else {
				// 		echo json_encode($gm->select_pre('pos_order_tb', null),JSON_PRETTY_PRINT);
				// 	}
				// break;




				case 'addOrder':
                    $d = json_decode(base64_decode(file_get_contents("php://input")));
                    echo json_encode($gm->insert("pos_preorder_tb",$d), JSON_PRETTY_PRINT);
                break;
				// case 'addPreOrder':
                //     $d = json_decode(base64_decode(file_get_contents("php://input")));
                //     echo json_encode($gm->insert("pos_order_tb",$d), JSON_PRETTY_PRINT);
                // break;
				case 'getProd':
                    $d = json_decode(base64_decode(file_get_contents("php://input")));
                    echo json_encode($gm->insert("menu_tb",$d), JSON_PRETTY_PRINT);
                break;
				case 'updatePreOrder':
                    $d = json_decode(base64_decode(file_get_contents("php://input")));
                    echo json_encode($gm->edit("pos_order_tb",$d), JSON_PRETTY_PRINT);
                break;
				case 'prod':                   
					if(count($req)>1) {                        
						echo json_encode($get->pullProduct($req[1]), JSON_PRETTY_PRINT);                   
					} 
				   else
				   {                        
						echo json_encode($get->pullProduct(null), JSON_PRETTY_PRINT); 
				   }                
						break;
				case 'order':                   
					 if(count($req)>1) {                        
						 echo json_encode($get->pullOrder($req[1]), JSON_PRETTY_PRINT);                   
					 } 
					else
					{                        
						 echo json_encode($get->pullOrder(null), JSON_PRETTY_PRINT); 
					}                
						 break;
						 
				 case 'delOrder': 
					    $d = json_decode(base64_decode(file_get_contents("php://input"))); 
						     echo json_encode($post->delOrder($d), JSON_PRETTY_PRINT);           
							break;
				 case 'delPre': 
					    $d = json_decode(base64_decode(file_get_contents("php://input"))); 
						     echo json_encode($post->delPre($d), JSON_PRETTY_PRINT);           
							break;
				 case 'clearOrder':
								$d = json_decode(base64_decode(file_get_contents("php://input")));
								echo json_encode($gm->clearOrder($d));
							break;

				// UPDATED FUNCTIONS

							case 'pushCode':
								$d = json_decode(base64_decode(file_get_contents("php://input")));
								echo json_encode($post->pushCode($d), JSON_PRETTY_PRINT);
							break;	

							case 'addPreOrderNew':
								$d = json_decode(base64_decode(file_get_contents("php://input")));
								echo json_encode($post->addPreOrderNew($d), JSON_PRETTY_PRINT);
							break;	

							case 'pre':
								$d = json_decode(base64_decode(file_get_contents("php://input")));
								echo json_encode($get->pullPreOrders($d), JSON_PRETTY_PRINT);    
							break;

							case 'preOrder':
								$d = json_decode(base64_decode(file_get_contents("php://input")));
								echo json_encode($get->pullPreOrderReceipt($d), JSON_PRETTY_PRINT);    
							break;

							case 'pullDetails':
								$d = json_decode(base64_decode(file_get_contents("php://input")));
								echo json_encode($get->pullDetails($d), JSON_PRETTY_PRINT);    
							break;

							case 'addOrderlist':
								$d = json_decode(base64_decode(file_get_contents("php://input")));
								echo json_encode($post->addOrderlist($d), JSON_PRETTY_PRINT);    
							break;

							case 'submittedOrder':
								$d = json_decode(base64_decode(file_get_contents("php://input")));
								echo json_encode($post->submittedOrder($d), JSON_PRETTY_PRINT);    
							break;


							
								
			}
		break;

		case 'GET':
			switch ($req[0]) {

				default:
				http_response_code(400);
				echo "Bad Request";
				break;
			}
		break;

		default:
			http_response_code(403);
			echo "Please contact the Systems Administrator";
		break;
	}
?>