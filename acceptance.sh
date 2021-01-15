# for Firefox (not working for me, I got: Undefined index: ELEMENT, see: https://github.com/php-webdriver/php-webdriver/issues/492)
# java -jar -Dwebdriver.gecko.driver=$SELENIUM/geckodriver $SELENIUM/selenium-server-standalone-3.141.59.jar

# for Google Chrome
java -jar -Dwebdriver.chrome.driver=$SELENIUM/chromedriver $SELENIUM/selenium-server-standalone-3.141.59.jar
