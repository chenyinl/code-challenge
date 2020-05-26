# A Simple User Login Tracking Application
![standard-readme compliant](https://img.shields.io/badge/readme%20style-standard-brightgreen.svg?style=flat-square)
![version](https://img.shields.io/badge/version-0.0.1-green.svg)
> Example of some web application security
![Screenshot](https://raw.githubusercontent.com/chenyinl/code-challenge/master/code-Challenge-Screen1.png)
## Table of Contents
- [Background](#background)
- [Summary](#summary)
- [Security Approach](#SecurityApproach)
- [Install](#install)
- [Deployment](#deployment)
- [Usage](#usage)
- [Output](#output)
- [Tests](#test)
- [Contributing](#contributing)
- [License](#license)
- [Reference](#reference)

## Background
This is a job application demo code, showing some coding practices for web application security.

## Summary
This application is using HTML, jQuery as front end UI, PHP 7 for REST API as backend.
mySQL as database.

<a name="SecurityApproach"></a>
## Security Approach
For the Security Risk listed on owasp.org, the following is the approach:
1. injection - in the database query, this app uses prepare statement, instead of just plain text.
It also set the database base connect to READ ONLY when reading the hash from the database.

2. Authentication - this app added Salt to hash the password

3. Sensitive Data Exposure - the app has internal message and public message, internal message has the
detail of the activities and is saved to the database; while the public message shows limited information
and is to be returned to the user.

4. Cross-Site Scripting - The cross domain Ajax is not allowed for this app.

5. Insufficient Logging & Monitoring - The database will log the user activities, if the 
database is offline, the error will be in the standard PHP error log.

6. If the log in fails, the UI will delay extra 3 seconds for the user has to wait some extra time to try again.

## Install
Clone the repo into the server.
Point the http root directory to the WEB folder


## Deployment
Execute the attach database.sql to setup the database.
Add database username and password in the Apache Server
```
<VirtualHost *:80>
  SetEnv db_username USERNAME
  SetEnv db_password PASSWORD
</VirtualHost>
```
The src folder should be only accessable from index.php, not through web server.

To use the Apache config file in this repository, simple create a symbolic link from sites-enabled directory to the file:
```
>sites-enabled> ln -v DOCROOT/apache.conf login_demo.conf
```

To change the domain name, we need to update the name in the two files below:
```
apache.conf
config/server.php
```

## Usage
There is only one row of user in the database. The username is **user1** and the password is **abcdef**.
```
> hash_hmac("sha256", PASSWORD, SALT);
```
Go to index.html to test the UI, or api.php to test with API.

## Output
The UI will show if the log in is success or not.
The API returns JSON for log in result.
The table login_activity will save the access activities.

## Test
PHP Unit is include in the test folder. Use the following comment to test:
```
> ./phpunit-9.1.phar HttpTesting.php
> ./phpunit-9.1.phar AuthTesting.php
```

## Files
config - configuration / parameters file
src    - main php class files
test   - Phpunit test
web    - public facing directory
README.md - this file
README_ASSIGNMENT.md original assignment file

## Contributing
PRs accepted.

## License

Private © 

## Reference
```
https://github.com/dermstore-com/code-challenge
https://owasp.org/www-project-top-ten/
```
