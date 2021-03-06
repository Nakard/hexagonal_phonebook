hexagonal_phonebook
===================

[![Build Status](https://travis-ci.org/Nakard/hexagonal_phonebook.svg?branch=master)](https://travis-ci.org/Nakard/hexagonal_phonebook)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/594db697-8cba-423b-93d0-0b3a8b3f7ac1/mini.png)](https://insight.sensiolabs.com/projects/594db697-8cba-423b-93d0-0b3a8b3f7ac1)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Nakard/hexagonal_phonebook/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Nakard/hexagonal_phonebook/?branch=master)
[![Coverage Status](https://coveralls.io/repos/Nakard/hexagonal_phonebook/badge.svg?branch=master&service=github)](https://coveralls.io/github/Nakard/hexagonal_phonebook?branch=master)

Demo application working as REST API with phone book functionality.

Inspired by [hexagonal architecture](http://alistair.cockburn.us/Hexagonal+architecture).

API documentation is generated with [NelmioApiDocBundle](https://github.com/nelmio/NelmioApiDocBundle) and is available at `http://{app_host}/api/doc`

Prior to app usage:
 * install dependencies with [Composer](https://getcomposer.org/)
 * run migrations with `app/console doctrine:migrations:migrate`

Test fixtures can be found in `UserBundle` and `PhoneBookBundle` tests directories
