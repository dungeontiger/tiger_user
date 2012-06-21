# 
# makefile for unit test
#

all: resultsUser.xml resultsUserException.xml

# User.php
resultsUser.xml: User.php UserTest.php
	phpunit --log-junit resultsUser.xml UserTest.php

# UserException.php
resultsUserException.xml: UserException.php UserExceptionTest.php
	phpunit --log-junit resultsUserException.xml UserExceptionTest.php
	
# code coverage
coverage: 
	phpunit --coverage-html CodeCoverageReports .
	
# clean
clean:
	rm -f resultsUser.xml resultsUserException.xml
	


