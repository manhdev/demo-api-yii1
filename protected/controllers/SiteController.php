<?php

class SiteController extends Controller
{
	public $layout='column1';

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Get all list person
	 */
	public function actionGetListPerson()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == 'GET') {
            $headers = apache_request_headers();
            $data['status'] = false;
            $data['status_code'] = 200;
            $data['message'] = 'Not Person';
            if (!empty($headers['Authority'])) {
                $username = 'admin';
                $pass = '123456';
                if (strpos($headers['Authority'], '-') != false) {
                    $str_ex = explode('-', $headers['Authority']);
                    if ($str_ex[0] == $username && $str_ex[1] == $pass) {
                        $list_person = $this->getListPerson();
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
                        $data['status_code'] = 200;//http_response_code(200);
                        $data['message'] = 'Success';
                        $data['count'] = $count;
                        $data['list_person'] = $list;
                        http_response_code(200);
                    } else {
                        http_response_code(403);
                        $data['message'] = 'Unauthorized';
                        $data['status_code'] = 403;
                    }
                } else {
                    http_response_code(403);
                    $data['message'] = 'Unauthorized';
                    $data['status_code'] = 403;
                }
            }
        }
        else{
            http_response_code(405);
            $data['message'] = 'Method Not Allowed';
            $data['status_code'] = 405;
        }
        echo json_encode($data);
	}

	/*
	 *  Create Person
	 */
	public function actionAddPerson(){
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == 'POST') {
            $headers = apache_request_headers();
            $data['status'] = false;
            $data['message'] = 'Not Person';
            if (!empty($headers['Authority'])) {
                $username = 'admin';
                $pass = '123456';
                if (strpos($headers['Authority'], '-') != false) {
                    $str_ex = explode('-', $headers['Authority']);
                    if ($str_ex[0] == $username && $str_ex[1] == $pass) {
                        $form_data = json_decode(file_get_contents('php://input'), true);
                        if(!empty($form_data['user_name']) && !empty($form_data['full_name']) && !empty($form_data['email'])) {
                            $user_name = $form_data['user_name'];
                            $full_name = $form_data['full_name'];
                            $email = $form_data['email'];
                            $model = new User();
                            $model->username = $user_name;
                            $model->profile = $full_name;
                            $model->email = $email;
                            $password = '123456';
                            $model->password_hash = $model->hashPassword($password);
                            if ($model->validate()) {
                                $model->save();
                                $data['status'] = true;
                                $data['status_code'] = 201;//http_response_code(200);
                                $data['message'] = 'Created';
                                http_response_code(201);
                            } else {
                                http_response_code(400);
                                $data['status_code'] = 400;
                                $data['message'] = 'Bad Request : Validate Fails';
                            }
                        }else{
                            http_response_code(400);
                            $data['status_code'] = 400;
                            $data['message'] = 'Bad Request : Params Invalid!';
                        }
                    } else {
                        http_response_code(403);
                        $data['message'] = 'Unauthorized';
                        $data['status_code'] = 403;
                    }
                } else {
                    http_response_code(403);
                    $data['message'] = 'Unauthorized';
                    $data['status_code'] = 403;
                }
            }else {
                http_response_code(403);
                $data['message'] = 'Unauthorized';
                $data['status_code'] = 403;
            }
        }else{
            http_response_code(405);
            $data['message'] = 'Method Not Allowed';
            $data['status_code'] = 405;
        }
        echo json_encode($data);
    }


    /*
	 *  Update Person
	 */
    public function actionUpdatePerson(){
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == 'GET') { // lấy thông tin người dùng
            $headers = apache_request_headers();
            $data['status'] = false;
            $data['message'] = 'Not Person';
            if (!empty($headers['Authority'])) {
                $username = 'admin';
                $pass = '123456';
                if (strpos($headers['Authority'], '-') != false) {
                    $str_ex = explode('-', $headers['Authority']);
                    if ($str_ex[0] == $username && $str_ex[1] == $pass) {
                        $model = User::model()->find('id='.$_GET['id']);
                        if ($model) {
                            $data['person'] = [
                                'id' => $model->id,
                                'user_name' => $model->username,
                                'full_name' => $model->profile,
                                'email' => $model->email
                            ];
                            $data['status'] = true;
                            $data['status_code'] = 200;//http_response_code(200);
                            $data['message'] = 'Success';
                            http_response_code(200);
                        }else{
                            http_response_code(400);
                            $data['status_code'] = 400;
                            $data['message'] = 'Bad Request : Params Invalid!';
                        }
                    } else {
                        http_response_code(403);
                        $data['message'] = 'Unauthorized';
                        $data['status_code'] = 403;
                    }
                } else {
                    http_response_code(403);
                    $data['message'] = 'Unauthorized';
                    $data['status_code'] = 403;
                }
            }
        }
        else if($method == 'PUT'){ // cập nhật thông tin người dùng
            $headers = apache_request_headers();
            $data['status'] = false;
            $data['message'] = 'Not Person';
            if (!empty($headers['Authority'])) {
                $username = 'admin';
                $pass = '123456';
                if (strpos($headers['Authority'], '-') != false) {
                    $str_ex = explode('-', $headers['Authority']);
                    if ($str_ex[0] == $username && $str_ex[1] == $pass) {
                        $form_data = json_decode(file_get_contents('php://input'), true);
                        $model = User::model()->find('id='.$form_data['id']);
                        if ($model) {
                            //$model->username = $form_data['user_name'];
                            $model->profile = $form_data['full_name'];
                            $model->email = $form_data['email'];
                            if($model->validate()){
                                $model->save();
                                $data['status'] = true;
                                $data['status_code'] = 200;//http_response_code(200);
                                $data['message'] = 'Success';
                                http_response_code(200);
                            }else{
                                http_response_code(400);
                                $data['status_code'] = 400;
                                $data['message'] = 'Bad Request : Params invalid';
                            }
                        }else{
                            http_response_code(404);
                            $data['status_code'] = 404;
                            $data['message'] = 'Bad Request : Not Found';
                        }
                    } else {
                        http_response_code(403);
                        $data['message'] = 'Unauthorized';
                        $data['status_code'] = 403;
                    }
                } else {
                    http_response_code(403);
                    $data['message'] = 'Unauthorized';
                    $data['status_code'] = 403;
                }
            }
        }else{
            http_response_code(405);
            $data['message'] = 'Method Not Allowed';
            $data['status_code'] = 405;
        }
        echo json_encode($data);
    }

    /*
	 *  Delete Person
	 */
    public function actionDeletePerson(){
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == 'DELETE') { //
            $headers = apache_request_headers();
            $data['status'] = false;
            $data['message'] = 'Not Person';
            if (!empty($headers['Authority'])) {
                $username = 'admin';
                $pass = '123456';
                if (strpos($headers['Authority'], '-') != false) {
                    $str_ex = explode('-', $headers['Authority']);
                    if ($str_ex[0] == $username && $str_ex[1] == $pass) {
                        $model = User::model()->find('id='.$_GET['id']);
                        if ($model) {
                            $model->delete();
                            $data['status'] = true;
                            $data['status_code'] = 200;//http_response_code(200);
                            $data['message'] = 'Success';
                            http_response_code(200);
                        }else{
                            http_response_code(404);
                            $data['status_code'] = 404;
                            $data['message'] = 'Bad Request : Not found person';
                        }
                    } else {
                        http_response_code(403);
                        $data['message'] = 'Unauthorized';
                        $data['status_code'] = 403;
                    }
                } else {
                    http_response_code(403);
                    $data['message'] = 'Unauthorized';
                    $data['status_code'] = 403;
                }
            }
        }else{
            http_response_code(405);
            $data['message'] = 'Method Not Allowed';
            $data['status_code'] = 405;
        }
        echo json_encode($data);
    }


    private function getListPerson(){
	    $model = new User();
	    $list_person = $model->search();
	    return $list_person;
    }

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (!defined('CRYPT_BLOWFISH')||!CRYPT_BLOWFISH)
			throw new CHttpException(500,"This application requires that PHP was compiled with Blowfish support for crypt().");

		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
	}
}
