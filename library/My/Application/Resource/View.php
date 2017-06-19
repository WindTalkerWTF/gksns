<?php
class My_Application_Resource_View extends Zend_Application_Resource_ResourceAbstract
{
	protected $_view;
 
    // 初始化 view
    public function init()
    {
        if (null === $this->_view) {
            // 获取从 Application.ini中 的配置
            $options = $this->getOptions();
            $view = new Zend_View($options);
            if (!empty($options['params'])) {
                foreach ($options['params'] as $key => $value) {
                    $view->$key = $value;
                }
            }
 
            // viewRenderer 动作助手
            $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
                'ViewRenderer'
            );
 
            // 保存配置好的视图对象
            $viewRenderer->setView($view);
            $this->_view = $view;
        }        
        return $this->_view;
    }
    
}