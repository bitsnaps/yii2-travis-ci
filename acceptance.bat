REM for Firefox (not tested on windows)
REM java -jar -Dwebdriver.gecko.driver=%SELENIUM%/geckodriver %SELENIUM%/selenium-server-standalone-3.141.59.jar

REM for Google Chrome
java -jar -Dwebdriver.chrome.driver=%SELENIUM%/chromedriver.exe %SELENIUM%/selenium-server-standalone-3.141.59.jar
