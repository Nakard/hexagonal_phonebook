<?php
$user = ['user' => ['firstName' => 'Zenobiusz', 'lastName' => 'Michalski', 'nickname' => 'dumb']];

$I = new ApiTester($scenario);
$I->wantTo('create user via API');
$I->haveHttpHeader('Content-Type', 'application/json');
$I->sendPOST('/users', $user);
$I->seeResponseCodeIs(201);
$I->seeResponseIsJson();