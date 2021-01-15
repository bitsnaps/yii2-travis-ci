<?php

use yii\helpers\Url;

class HomeCest
{
    public function ensureThatHomePageWorks(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));
        $I->see('My Company');

        $I->seeLink('About');
        $I->click('About');

        try {
          // there is no wait() with PhpBrowser
          $I->wait(2); // wait for page to be opened
        } catch (\Exception $e) {
        }

        $I->see('This is the About page.');
    }
}
