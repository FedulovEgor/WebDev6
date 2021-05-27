<?php
use app\fixtures\ImagesFixture;
use app\fixtures\UserFixture;
use app\models\Images;

class LoginFormCest
{
    	public function _fixtures() // Подключение Fixtures
    	{
            return [ 
		// Подключение Fixtures пользователи
            	'users' => [ 
                    'class' => UserFixture::className(),
                    'dataFile' => codecept_data_dir() . 'users.php'
            	    ],
		// Подключение Fixtures картинки
            	'images' => [
                    'class' => ImagesFixture::className(),
                    'dataFile' => codecept_data_dir() . 'images.php'
            	],
            ];
    }

    public function _before(\FunctionalTester $I)
    {	
	session_save_path(yii::$app->basePath.'/sessions/');
	$I->amOnRoute('site/login');

	
    }

    public function openLoginPage(\FunctionalTester $I)
    {
        $I->see('Login', 'h1');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginById(\FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnPage('admin/lab/index');
        $I->see('Logout (root)');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginByInstance(\FunctionalTester $I)
    {
        $I->amLoggedInAs(\app\models\UserIdentity::findByUsername('root'));
        $I->amOnPage('admin/lab/index');
        $I->see('Logout (root)');
    }

    public function loginWithEmptyCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', []);
        $I->expectTo('see validations errors');
        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
    }

    public function loginWithWrongCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'root',
            'LoginForm[password]' => 'wrong',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Incorrect username or password.');
    }

    public function loginSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'root',
            'LoginForm[password]' => '123456',
        ]);
        $I->see('Logout (root)');
        $I->dontSeeElement('form#login-form');              
    }
}
