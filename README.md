# demo-api-yii1

API Using Yii1

1.Step 1: Client Call API:

        $url = 'http://abcxyz.host/index.php/site/getListPerson'; // Url API
        
        $curl = curl_init($url); // init service Curl
        
        $user_name = 'admin'; // username for authenciation add header
        
        $pass = '123456'; // password for authenciation add header
        
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authority:'.$user_name.'-'.$pass)); // add header
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET'); // define method GET(for get data) /POST(for create) /PUT(for Update) /DELETE(for Delete)
        
        $result = curl_exec($curl); // result after send request
        
        $data = json_decode($result, true); // decode data type json
        
        curl_close($curl); // close service
    
2.Step 2:  Server received request and return data . create function action getListPerson

        $method = $_SERVER['REQUEST_METHOD']; // get request method of client submit 
        
        if($method == 'GET') { // if method is GET
        
            $headers = apache_request_headers(); // get header of method : Because We using header for Authenciation
            
            $data['status'] = false; // status: true | false
            
            $data['status_code'] = 200; // status code  view more https://www.restapitutorial.com/httpstatuscodes.html
            
            $data['message'] = 'Not Person'; // message return 
            
            if (!empty($headers['Authority'])) { // check if $header has Authority
            
                $username = 'admin'; 
                
                $pass = '123456';
                
                if (strpos($headers['Authority'], '-') != false) {
                
                    $str_ex = explode('-', $headers['Authority']);
                    
                    if ($str_ex[0] == $username && $str_ex[1] == $pass) { // check username & password if ok 
                    
                        $list_person = $this->getListPerson(); // get list person 
                        
                        $list = [];
                        
                        $count = 0;
                        
                        if(!empty($list_person)){
                        
                            foreach ($list_person as $item) {
                            
                                $list[] = [
                                
                                    'id' => $item->id,
                                    
                                    'full_name' => $item->profile,
                                    
                                    'user_name' => $item->username,
                                    
                                    'email' => $item->email
                                   
                                ];
                                
                                $count++;
                                
                            }
                            
                        }

                        $data['status'] = true;
                        
                        $data['status_code'] = 200;//http_response_code(200); // status code view more https://www.restapitutorial.com/httpstatuscodes.html
                        
                        $data['message'] = 'Success';
                        
                        $data['count'] = $count;
                        
                        $data['list_person'] = $list;
                        
                        http_response_code(200); // status response data ok view more https://www.restapitutorial.com/httpstatuscodes.html
                        
                    } else {
                        http_response_code(403); // Authenciate Fails : Username or password incorrect
                        
                        $data['message'] = 'Unauthorized'; // content of message
                        
                        $data['status_code'] = 403; // status return for client
                        
                    }
                } else {
                    http_response_code(403);
                    
                    $data['message'] = 'Unauthorized';
                    
                    $data['status_code'] = 403;
                    
                }
                
            }
            
        }
        
        else{
        
            http_response_code(405); // method not allow view more https://www.restapitutorial.com/httpstatuscodes.html
            
            $data['message'] = 'Method Not Allowed';
            
            $data['status_code'] = 405;
            
        }
        
        echo json_encode($data); // return data for client 
        
  3.Function getListPerson for Server API 
  
        $model = new User();

        $list_person = User::model()->findAll();

        return $list_person;
