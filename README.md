<p align="center">
    <h1 align="center">Yii 2 Basic Project with travis-ci</h1>
    <br>
</p>


[![Build Status](https://travis-ci.com/bitsnaps/yii2-travis-ci.svg?token=yqPkBrU4E7xd57wLh2mu&branch=master)](https://travis-ci.com/bitsnaps/yii2-travis-ci)


TESTING
-------

Tests are located in `tests` directory. They are developed with [Codeception PHP Testing Framework](http://codeception.com/).
By default there are 3 test suites:

- `unit`
- `functional`
- `acceptance`

Tests can be executed by running

```
vendor/bin/codecept run
```

The command above will execute unit and functional tests. Unit tests are testing the system components, while functional
tests are for testing user interaction. Acceptance tests are disabled by default as they require additional setup since
they perform testing in real browser.


### Running acceptance tests

To execute acceptance tests do the following:  

1. Rename `tests/acceptance.suite.yml.example` to `tests/acceptance.suite.yml` to enable suite configuration
You can do this with the following command:
```
mv tests/acceptance.suite.yml.example tests/acceptance.suite.yml
```

2. Replace `codeception/base` package in `composer.json` with `codeception/codeception` to install full featured
   version of Codeception

3. Update dependencies with Composer

    ```
    composer update  
    ```

4. Download [Selenium Server](http://www.seleniumhq.org/download/) and launch it:

    ```
    java -jar ~/selenium-server-standalone-x.xx.x.jar
    ```

    In case of using Selenium Server 3.0 with Firefox browser since v48 or Google Chrome since v53 you must download [GeckoDriver](https://github.com/mozilla/geckodriver/releases) or [ChromeDriver](https://sites.google.com/a/chromium.org/chromedriver/downloads) and launch Selenium with it:

    ```
    # for Firefox
    java -jar -Dwebdriver.gecko.driver=~/geckodriver ~/selenium-server-standalone-3.xx.x.jar

    # for Google Chrome
    java -jar -Dwebdriver.chrome.driver=~/chromedriver ~/selenium-server-standalone-3.xx.x.jar
    ```

    As an alternative way you can use already configured Docker container with older versions of Selenium and Firefox:

    ```
    docker run --net=host selenium/standalone-firefox:2.53.0
    ```
P.S. You can use the `acceptance.sh` (or `acceptance.bat` for windows) to run selenium server on real (chrome) browser (you must define :`SELENIUM` environment variable).

5. (Optional) Create `yii2_basic_tests` database and update it by applying migrations if you have them.

   ```
   tests/bin/yii migrate
   ```

   The database configuration can be found at `config/test_db.php`.


6. Start web server:

    ```
    tests/bin/yii serve
    ```
A Selenium Server will be started.

Note:
- For acceptance WebDriver module is used. Please check its reference to learn how to work with it. Unlike Yii2 module it does know nothing about your application, so if you want to use features of Yii like fixtures for acceptance testing, you should check that enable Yii2 module is enabled as well:
```
# config at tests/acceptance.yml
modules:
    enabled:
        - WebDriver:
            url: http://127.0.0.1:8080/
            browser: firefox
        - Yii2:
            part: [orm, fixtures] # allow to use AR methods
            cleanup: false # don't wrap test in transaction
            entryScript: index-test.php
```

7. Now you can run all available tests

   ```
   # run all available tests
   vendor/bin/codecept run

   # run acceptance tests
   vendor/bin/codecept run acceptance

   # run only unit and functional tests
   vendor/bin/codecept run unit,functional
   ```

### Code coverage support

P.S. Before jump into coverage, make sure [xdebug](https://xdebug.org/) php's extension is installed (or just enabled in case of using software bundle like XAMPP).
To find out if `xdebug` is installed run the following command:
```
php -v | grep -i xdebug
```

By default, code coverage is disabled by default in `codeception.yml` configuration file, but it's enabled in this example, you can comment out unnecessary rows to disable collecting code coverage.
You can run your tests and collect coverage with the following command:

```
#collect coverage for all tests
php vendor/bin/codecept run --coverage --coverage-html --coverage-xml

#collect coverage only for unit tests
php vendor/bin/codecept run unit --coverage --coverage-html --coverage-xml

#collect coverage for unit and functional tests
php vendor/bin/codecept run functional,unit --coverage --coverage-html --coverage-xml
```

You can see code coverage output under the `tests/_output` directory (for html report open `coverage/index.html` or `coverage-xml/index.html` for the xml).

Find out more about [Yii2-Code-Coverage](https://github.com/davibennun/yii2/blob/master/vendor/codeception/codeception/docs/11-Codecoverage.md).

### Create a unit test:
Create a test using `generate:test` command with a suite and test names as parameters:
```
php vendor/bin/codecept generate:test unit Example
```
It creates a new ExampleTest file located in the tests/unit directory.
Notes that:
- all public methods with test prefix are tests
- `_before` method is executed before each test (like `setUp` in PHPUnit)
- `_after` method is executed after each test (like `tearDown` in PHPUnit)

#### Executing a unit test:
You can run the newly created `ExampleTest` with this command:
```
php vendor/bin/codecept run unit ExampleTest
```

### Create Cest files
Functional tests should be written inside Cest files, which is a scenario-driven test format of Codeception. You can easily create a new test by running:
```
./vendor/bin/codecept g:cest functional MyNewScenarioCest
```

You can also create a Cest file by running the command:
```
php vendor/bin/codecept generate:cest suitename CestName
```

## Rest API Testing
API tests are not included in any Yii templates so you need to set up them manually if you developing a web service. API testing is done at functional testing level but instead of testing HTML responses on user actions, they test requests and responses via protocols like REST or SOAP.
You can create a suite test for API using this command:
```
./vendor/bin/codecept g:suite api
```
You will need to enable `REST`, `Yii2` module in `tests/api.suite.yml`:
```
class_name: ApiTester
modules:
    enabled:
        - REST:
            url: /api/v1
            depends: Yii2
        - \ApiBundle\Helper\Api
    config:
        - Yii2
```
Yii2 module actions like amOnPage or see should not be available for testing API. This is why Yii2 module is not enabled but declared with depends for REST module. Read more about from here [API-Testing](https://codeception.com/docs/10-APITesting#REST-API)

## Acceptance test:
Similar as for functional tests it is recommended to use Cest format for acceptance testing:
```
./vendor/bin/codecept g:cest acceptance MyNewScenarioCest
```
Read more about acceptance test from [Acceptance-Tests](https://codeception.com/docs/03-AcceptanceTests)

More about testing with Yii2 can be found here [Yii2-Testing](https://codeception.com/for/yii)

### Selenium for automated Browser testing

This scenario can be performed either by `PhpBrowser` (which is the detault in this example to speed up testing on travis) or by a "real" browser (only chrome tested in this repo) through `WebDriver`, you can find all the details in: `tests/acceptance.suite.yml`.
