<?php

namespace tests\unit\models;

use app\models\User;

class UserTest extends \Codeception\Test\Unit
{

  // Dependency Injection example (for more details see: https://codeception.com/docs/07-AdvancedUsage#Cest-Classes)
    /*
     * @var Helper\SignUp
     *
    protected $signUp;

    /**
     * @var Helper\NavBarHelper
     *
    protected $navBar;

    protected function _inject(\Helper\SignUp $signUp, \Helper\NavBar $navBar)
    {
        $this->signUp = $signUp;
        $this->navBar = $navBar;
    }

    public function signUp(\AcceptanceTester $I)
    {
        $this->navBar->click('Sign up');
        $this->signUp->register([
            'first_name'            => 'Joe',
            'last_name'             => 'Jones',
            'email'                 => 'joe@jones.com',
            'password'              => '1234',
            'password_confirmation' => '1234'
        ]);
    }
    */

    public function testFindUserById()
    {
        expect_that($user = User::findIdentity(100));
        expect($user->username)->equals('admin');

        expect_not(User::findIdentity(999));
    }

    public function testFindUserByAccessToken()
    {
        expect_that($user = User::findIdentityByAccessToken('100-token'));
        expect($user->username)->equals('admin');

        expect_not(User::findIdentityByAccessToken('non-existing'));
    }

    public function testFindUserByUsername()
    {
        expect_that($user = User::findByUsername('admin'));
        expect_not(User::findByUsername('not-admin'));
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser($user)
    {
        $user = User::findByUsername('admin');
        expect_that($user->validateAuthKey('test100key'));
        expect_not($user->validateAuthKey('test102key'));

        expect_that($user->validatePassword('admin'));
        expect_not($user->validatePassword('123456'));
    }

    /*
    // Unit tests are focused around a single component of an application.
    // All external dependencies for components should be replaced with test doubles.
    // Source: https://codeception.com/docs/05-UnitTests

    public function testValidation()
    {
        $user = new User();

        $user->setName(null);
        $this->assertFalse($user->validate(['username']));

        $user->setName('toolooooongnaaaaaaameeee');
        $this->assertFalse($user->validate(['username']));

        $user->setName('davert');
        $this->assertTrue($user->validate(['username']));
    }
    */

    /*
    // Testing with Doubles
    // Codeception provides Codeception\Stub library for building mocks and stubs for tests.
    // Under the hood it used PHPUnit’s mock builder but with much simplified API.
    public function testValidation()
    {
      $user = \Codeception\Stub::make('User', ['getName' => 'john']);
      $name = $user->getName(); // 'john'

      // Inside unit tests (Codeception\Test\Unit) it is recommended to use alternative API:
      // create a stub with find method replaced
      $userRepository = $this->make(UserRepository::class, ['find' => new User]);
      $userRepository->find(1); // => User

      // create a dummy
      $userRepository = $this->makeEmpty(UserRepository::class);

      // create a stub with all methods replaced except one
      $user = $this->makeEmptyExcept(User::class, 'validate');
      $user->validate($data);

      // create a stub by calling constructor and replacing a method
      $user = $this->construct(User::class, ['name' => 'davert'], ['save' => false]);

      // create a stub by calling constructor with empty methods
      $user = $this->constructEmpty(User::class, ['name' => 'davert']);

      // create a stub by calling constructor with empty methods
      $user = $this->constructEmptyExcept(User::class, 'getName', ['name' => 'davert']);
      $user->getName(); // => davert
      $user->setName('jane'); // => this method is empty

      // Stubs can also be created using static methods from Codeception\Stub class. In this
      \Codeception\Stub::make(UserRepository::class, ['find' => new User]);

      // Mocks: To declare expectations for mocks use Codeception\Stub\Expected class:

      // create a mock where $user->getName() should never be called
      $user = $this->make('User', [
           'getName' => Expected::never(),
           'someMethod' => function() {}
      ]);
      $user->someMethod();

      // create a mock where $user->getName() should be called at least once
      $user = $this->make('User', [
              'getName' => Expected::atLeastOnce('Davert')
          ]
      );
      $user->getName();
      $userName = $user->getName();
      $this->assertEquals('Davert', $userName);

    }
    */

}
