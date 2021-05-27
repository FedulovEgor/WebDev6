<?php

namespace tests\unit\models;

use app\models\UserIdentity;
//use app\tests\fixtures\UserFixture;
use app\fixtures\UserFixture;


class UserIdentityTest extends \Codeception\Test\Unit
{
    protected $tester;

    public function _fixtures()
    {
	
    }

    public function _before()
    {
	$this->tester->haveFixtures([
            'users' => [
            	'class' => UserFixture::className(),
            	'dataFile' => codecept_data_dir() . 'users.php'
            ],
    	]);
    }

    public function testFindUserByUsernameFixture()
    {
	//sleep(15);
    }

    public function testFindUserById()
    {
        expect_that($user = UserIdentity::findIdentity(1));
        expect($user->username)->equals('root');

        expect_that($user = UserIdentity::findIdentity(1000));
        expect($user->username)->equals('user1_test');

        expect_not(UserIdentity::findIdentity(999));
    }

    public function testFindUserByAccessToken()
    {
        expect_that($user = UserIdentity::findIdentityByAccessToken(null));
        expect($user->username)->equals('root');

        expect_not(UserIdentity::findIdentityByAccessToken('non-existing'));        
    }

    public function testFindUserByUsername()
    {
        expect_that($user = UserIdentity::findByUsername('root'));
        $user = UserIdentity::findByUsername('user1_test');
        expect_not(UserIdentity::findByUsername('not-admin'));
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser()
    {
        $user = UserIdentity::findByUsername('root');
        expect_that($user->validateAuthKey(null));
	expect_not($user->validateAuthKey('test102key'));

        expect_that($user->validatePassword('123456'));
        expect_not($user->validatePassword('qwerty')); 

        $user = UserIdentity::findByUsername('user1_test');
        expect_that($user->validateAuthKey(null));
	expect_not($user->validateAuthKey('test102key'));

        expect_that($user->validatePassword('user1_test'));
        expect_not($user->validatePassword('qwerty'));       
    }



}
