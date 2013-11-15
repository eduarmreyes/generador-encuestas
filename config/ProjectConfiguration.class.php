<?php
date_default_timezone_get("America/El_Salvador");
setlocale(LC_ALL, "");
require_once dirname(__FILE__) . "/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php";
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfDoctrinePlugin');
    $this->enablePlugins('sfDoctrineGuardPlugin');
  }
}
