<?php

namespace noval;

use Craft;
// The following imports are required to listen for the the RESTful requests
use craft\events\RegisterUrlRulesEvent;
use craft\web\UrlManager;
use yii\base\Event;

class Module extends \yii\base\Module
{
  public function init()
  {
    Craft::setAlias("@noval", __DIR__);

    if (Craft::$app->getRequest()->getIsConsoleRequest()) {
      $this->controllerNamespace = 'noval\\console\\controllers';
    } else {
      $this->controllerNamespace = 'noval\\controllers';
    }

    parent::init();

    // Add Events for the URL Rules
    Event::on(
      UrlManager::class,
      UrlManager::EVENT_REGISTER_SITE_URL_RULES,
      function (RegisterUrlRulesEvent $event) {
        $event->rules = array_merge($event->rules, [
          'GET api/noval' => 'noval/noval/resolve-request',
        ]);
      }
    );
  }
}
