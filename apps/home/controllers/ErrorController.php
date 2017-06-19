<?php
class ErrorController extends My_Controller_Action
{

	public function errorAction()
	{
		$errors = $this->_getParam('my_error_handler');
		if($errors){
			switch ($errors->type) {
				case My_Controller_Plugin_MyErrorHandler::EXCEPTION_NO_ROUTE:
				case My_Controller_Plugin_MyErrorHandler::EXCEPTION_NO_CONTROLLER:
				case My_Controller_Plugin_MyErrorHandler::EXCEPTION_NO_ACTION:
	
					// 404 error -- controller or action not found
					$this->getResponse()->setHttpResponseCode(404);
					$this->view->message = '页面不存在!';
					break;
				Case My_Controller_Plugin_MyErrorHandler::EXCEPTION_PARAM_CHECK;
					$this->getResponse()->setHttpResponseCode(500);
					$this->view->message = $errors->exception->getMessage();
					break;
				default:
					// application error
					$this->getResponse()->setHttpResponseCode(500);
					$this->view->message = '出错啦!';
					break;
			}
			$logs[] = My_Tool::getCurrentUrl();
			$logs[] = print_r($_REQUEST,true);
			$logs[] = $this->view->message;
			$logs[] = $errors->exception;
			$path = ROOT_DIR  . "/data/logs/".date('Y-m-d')."/error-log.txt.php";
	        Home_Tool_Log::save($logs, $path);
	
			// conditionally display exceptions
			if(isDebug()) {
				$this->view->exception = $errors->exception;
			}
	
			$this->view->request   = $errors->request;
		}
		$this->_helper->layout()->disableLayout();
	}


}



