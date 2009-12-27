<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
  protected function _initAutoload()
  {
    $autoLoader = Zend_Loader_Autoloader::getInstance();
    $autoLoader->registerNamespace('MyLib_');
    $resourceLoader = new Zend_Loader_Autoloader_Resource(
      array('basePath' => APPLICATION_PATH, 'namespace' => '')
    );

    $this->bootstrap('frontController');
    $this->frontController->addControllerDirectory(APPLICATION_PATH . '/controllers');

    return $autoLoader;
  }


  protected function _initView()
  {
    $view = new Zend_View();
    $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
    $viewRenderer->setView($view);
    return $view;
  }

  protected function _initLog()
  {
    $this->bootstrap('autoload');

    $filter = new Zend_Log_Filter_Priority(Zend_Log::DEBUG);

    $baseLogPath = BASE_PATH . '/logs';

    if (APPLICATION_ENV === 'testing')
    {
      // For unit tests
      $logPath = $baseLogPath . '/tests';
    }
    else if (defined('CRON'))
    {
      $logPath = $baseLogPath . '/cron';
    }
    else
    {
      $logPath = $baseLogPath . '/app';
    }

    $writer = new Zend_Log_Writer_Stream($logPath . '/' . date('d-m-Y').'.log');
    $log = new Zend_Log($writer);
    $log->addFilter($filter);

    return $log;
  }

  protected function _initFireLog()
  {
    $this->bootstrap('autoload');

    $fireWriter = new Zend_Log_Writer_Firebug();
    $log = new Zend_Log($fireWriter);

    return $log;
  }
}

