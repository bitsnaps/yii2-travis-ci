<?php

use yii\helpers\Url;

// more about Acceptance testing: https://codeception.com/docs/03-AcceptanceTests
class AboutCest
{
    public function ensureThatAboutWorks(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/about'));
        $I->see('About', 'h1');

        // $I->amOnPage(Url::toRoute('/site/index'));
        // $I->seeElement('.container');


        // $I->amOnPage('?r=site%2Findex');
        // $I->see('Congratulations!', 'h1');

        // $I->selectOption('Gender','Male');
        // $I->click('Update');
        // $I->submitForm('#update_form', array('user' => array(
        //      'name' => 'Miles',
        //      'email' => 'Davis',
        //      'gender' => 'm'
        // )));

        // $I->expectTo('see user login');
        // $I->see('Heading', 'h2');
    }
}
