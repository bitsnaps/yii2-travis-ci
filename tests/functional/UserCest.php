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

    public function canListUsers(\FunctionalTester $I)
    {
      $I->amOnPage(['user/index']);
      $I->see('Users', 'h1');
    }

    public function canViewUserById(\FunctionalTester $I)
    {
      $user1 = $I->grabFixture('users', 'user1');
      $I->amOnPage(['user/view', 'id' => $user1->id]);
      $I->see($user1->id, 'h1');
    }

    // public function canDeleteUserById(\FunctionalTester $I)
    // {
    //   $user1 = $I->grabFixture('users', 'user1');
    //   $total = count($I->grabFixture('users')) - 1;
    //   $I->amOnPage(['user/delete', 'id' => $user1->id]);
    //   $I->performOn(['title'=>"Delete"], \Codeception\Util\ActionSequence::build()
    //       ->see('Warning')
    //       ->see('Are you sure you want to delete this item?')
    //       ->click('Yes'));
    //   $I->seeInTitle('Users');
    // }

    public function cannotCreateUserWithEmptyForm(\FunctionalTester $I)
    {
      $I->amOnPage(['user/create']);
      $I->submitForm('#user-form', []);
      $I->expectTo('see validations errors');
    }

    public function cannotCreateUserWithoutStatus(\FunctionalTester $I)
    {
      $I->amOnPage(['user/create']);
      $I->submitForm('#user-form', [
        'User[username]' => 'user123',
        'User[password_hash]' => 'user123',
        'User[status]' => null,
      ]);
      $I->seeInTitle('Create User');
      $I->expectTo('see that status is wrong');
      $I->see('Status cannot be blank.');
    }

    public function canCreateUser(\FunctionalTester $I)
    {
      $I->amOnPage(['user/create']);
      $I->see('Create User', 'h1');

      $formElement = '#user-form';

      $I->submitForm($formElement, [
        'User[username]' => 'user123',
        'User[password_hash]' => 'user123',
        'User[status]' => 10,
      ]);
      $I->dontSeeElement($formElement);
      $I->seeInCurrentUrl('user%2Fview'); // not very accurrate though
      // $I->seeCurrentUrlEquals('/user/view'); // wrong in this case
      // $I->seeCurrentUrlMatches('~^user(\d+)~'); // use RegEx
    }

    public function totalUserCalculated(\FunctionalTester $I)
    {
        $users = $I->grabFixture('users');
        $total = count($users);
        $I->see("Showing 1-$total of $total items.", 'div.summary');
    }



}
