<?php

namespace noval\controllers;

use Craft;
use craft\elements\Entry;
use craft\models\Section;
use craft\services\Entries;
use craft\web\Controller;

class NovalController extends Controller
{
  protected array|bool|int $allowAnonymous = true;

  public function actionResolveRequest()
  {
    // $entry = Craft::$app->getEntries()->getEntryById(12, 1);
    $section = Craft::$app->entries->getSectionByHandle('drinks');
    $entryTypes = $section->getEntryTypes();
    $site = $section->getSiteIds();
    $fieldLayout = $entryTypes[0]->getFieldLayout();
    $fields = $fieldLayout->getCustomFields();
    $entry = new Entry();
    $entry->sectionId = $section->id;
    $entry->siteId = $site[0];
    $entry->typeId = $entryTypes[0]->id;
    $entry->slug = "from-api";
    $entry->title = "From API";
    $entry->introduction = "INtro dah bg";
    $entry->pageCopy = "iyee bg";
    $success = Craft::$app->getElements()->saveElement($entry);
    return $this->sendResponse(200, null, $entry);
  }

  /**
   * Send a response based on a status code ($code), an error ($error) & a response ($response).
   *
   * @return array
   */

  public function sendResponse(int $code, mixed $error, mixed $response)
  {
    return $this->asJSON([
      'statusCode' => $code,
      'headers' => [
        "Access-Control-Allow-Origin"  => "*", // Required for CORS support to work
        "Access-Control-Allow-Credentials" => true, // Required for cookies, authorization headers with HTTPS
        "Content-Type" => "application/json"
      ],
      'body' => [
        'error' => $error,
        'response' => $response
      ]
    ]);
  }
}
