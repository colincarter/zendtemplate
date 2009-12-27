<?php

require_once dirname(__FILE__).'/../application/zendinit.php';

$application->bootstrap();

if (APPLICATION_ENV !== 'testing')
{
  $application->run();
}
