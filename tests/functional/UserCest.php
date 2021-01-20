<?php

use app\models\User;
use app\tests\fixtures\UserFixture;

class UserCest
{

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
        $I->amLoggedInAs(User::find()->one());
        $I->amOnPage(['user/index']);
    }

    public function _after(\FunctionalTester $I)
    {
    }

    public function onUsersPage(\FunctionalTester $I)
    {
      $I->see('Users', 'h1');
    }

    public function usersHasBeenCreated(\FunctionalTester $I)
    {
        $user1 = $I->grabFixture('users', 'user1');
        $I->see($user1->username, 'td');

        $user2 = $I->grabFixture('users', 'user2');
        $I->see($user2->username, 'td');
    }

    public function totalUserCalculated(\FunctionalTester $I)
    {
        $users = $I->grabFixture('users');
        $total = count($users);
        $I->see("Showing 1-$total of $total items.", 'div.summary');
    }



}
