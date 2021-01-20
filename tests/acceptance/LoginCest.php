<?php

use yii\helpers\Url;
use app\tests\fixtures\UserFixture;

class LoginCest
{

    // Fixtures are needed here
    public function _fixtures()
    {
      return [
        'users' => [
          'class' => UserFixture::class,
        ]
      ];
    }

    public function _before(\FunctionalTester $I)
    {
        $users = $I->grabFixture('users');
    }

    public function _after(\FunctionalTester $I)
    {
    }

    public function ensureThatLoginWorks(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/login'));
        $I->see('Login', 'h1');

        $I->amGoingTo('try to login with correct credentials');
        $I->fillField('input[name="LoginForm[username]"]', 'admin');
        $I->fillField('input[name="LoginForm[password]"]', 'admin');
        $I->click('login-button');

        try {
          // there is no wait() with PhpBrowser
          $I->wait(2); // wait for button to be clicked
        } catch (\Exception $e) {
        }

        $I->expectTo('see user info');
        $I->see('Logout');
    }
}
