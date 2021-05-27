<?php

use yii\helpers\Url;
use app\fixtures\ImagesFixture;
use app\fixtures\UserFixture;


class LoginCest
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

    public function ensureThatTestWorks(AcceptanceTester $I)
    {
        $I->amOnPage('www.wikipedia.org');
        //$I->see('Wikipedia');
	$I->see('Not Found', 'h1');
    }
/*
    public function ensureThatLoginWorks(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/login'));
        $I->see('Login', 'h1');

        $I->amGoingTo('try to login with correct credentials');
        $I->fillField('input[name="LoginForm[username]"]', 'root');
        $I->fillField('input[name="LoginForm[password]"]', '123456');
        $I->click('login-button');
        $I->wait(2); // wait for button to be clicked

        $I->expectTo('see user info');
        $I->see('Logout');
    }
*/
}
