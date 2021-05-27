<?php

namespace tests\unit\models;

use app\models\LoginForm;
use app\fixtures\UserFixture;
use yii;

class LoginFormTest extends \Codeception\Test\Unit
{
    private $model;

    public function _before()
    {
	session_save_path(yii::$app->basePath.'/sessions/');
	$this->tester->haveFixtures([
            'users' => [
            	'class' => UserFixture::className(),
            	'dataFile' => codecept_data_dir() . 'users.php'
            ],
    	]);
    }

    protected function _after()
    {
        \Yii::$app->user->logout();
    }

    public function testLoginNoUser()
    {
        $this->model = new LoginForm([
            'username' => 'not_existing_username',
            'password' => 'not_existing_password',
        ]);

        expect_not($this->model->login());
        expect_that(\Yii::$app->user->isGuest);
    }

    public function testLoginWrongPassword()
    {
        $this->model = new LoginForm([
            'username' => 'root',
            'password' => 'wrong_password',
        ]);

        expect_not($this->model->login());
        expect_that(\Yii::$app->user->isGuest);
        expect($this->model->errors)->hasKey('password');
    }

    public function testLoginCorrect()
    {
        $this->model = new LoginForm([
            'username' => 'root',
            'password' => '123456',
        ]);

        expect_that($this->model->login());
        expect_not(\Yii::$app->user->isGuest);
        expect($this->model->errors)->hasntKey('password');
    }

}

