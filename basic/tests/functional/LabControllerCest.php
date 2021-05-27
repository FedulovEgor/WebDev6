<?php

use app\fixtures\ImagesFixture;
use app\fixtures\UserFixture;
use app\models\Images;
use yii\web\UploadedFile;
use yii\helpers\Url;

class LabControllerCest
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
        	$I->amOnRoute('admin/lab/index');
    	} 
	
	public function redirectToLoginPage(\FunctionalTester $I)
    	{
        	$I->see('Login', 'h1'); // Тестер видит тег h1 с текстом логин
    	}

	public function openAlbumLoggedIn(\FunctionalTester $I)
    	{
        	$I->amLoggedInAs(\app\models\UserIdentity::findByUsername('root')); // Тестер залогинен User с id 1
        	$I->amOnRoute('admin/lab/index'); // Тестер переходит на lab/index
        	$I->see('Images', 'h1'); // Тестер видит тег h1 с текстом Album
        	$I->see('123456', 'td'); // Тестер видит ячейку таблицы с текстом 
        	$I->see('0123456789', 'td'); // Тестер видит ячейку таблицы с текстом 
    	}

	public function albumUploadImageClick(\FunctionalTester $I)
    	{
        	$I->amLoggedInAs(\app\models\UserIdentity::findByUsername('root'));
		$I->amOnRoute('admin/lab/index');
		$I->see('Images', 'h1');
		$I->see('Upload', 'a');
        	$I->click('Upload');
        	$I->see('Create Images', 'h1');
    	}

	public function albumUploadImage(\FunctionalTester $I)
    	{
        	$I->amLoggedInAs(\app\models\UserIdentity::findByUsername('root')); // Тестер залогинен User с id 1
        	$I->amOnRoute('admin/lab/create'); // Тестер переходит на album/index для первого пользователя
        	$I->see('Create Images', 'h1');
		$I->attachFile('input[type="file"]', 'test_1.jpg');
        	$I->click('Submit');
        	$I->see('Update Images', 'h1');

    	}

	public function albumSetCaptionForImage(\FunctionalTester $I)
    	{
        	$I->amLoggedInAs(\app\models\UserIdentity::findByUsername('root')); // Тестер залогинен User с id 1
        	$I->amOnRoute('admin/lab/update', ['id' => 10]); // Тестер переходит на album/index для первого пользователя
        	$I->see('Update Images');
        	$I->fillField('input[name="Images[caption]"]', 'caption'); // заполнение поля
        	$I->click('Save');
        	$I->see('picture1_test', 'h1');

        	$I->see('caption'); // 
    	}

	public function albumClickHome(\FunctionalTester $I)
    	{
        	$I->amLoggedInAs(\app\models\UserIdentity::findByUsername('root'));
        	$I->amOnRoute('admin/lab/view', ['id' => 10]);
        	$I->click('Home');
        	$I->see('Images');
    	}
	
	public function albumConfirmDeleteImage(\FunctionalTester $I)
    	{
        	$I->amLoggedInAs(\app\models\UserIdentity::findByUsername('root'));
        	$I->amOnRoute('admin/lab/view', ['id' => 10]);
        	//$I->click('Delete');
        	//$I->see('Are you sure you want to delete this image?');

		$I->amGoingTo('delete item');
        	$I->sendAjaxPostRequest(Url::to(['/admin/lab/delete', 'id' => 10]));
		$I->expectTo('see that image is deleted');
		$I->dontSeeRecord(Images::className(), [
            		'name' => 'picture1_test',
        	]);
    	}

    	public function albumConfirmDeleteNotFoundImage(\FunctionalTester $I)
    	{
        	$I->amLoggedInAs(\app\models\UserIdentity::findByUsername('root'));
        	$I->amOnRoute('admin/lab/view', ['id' => 10000]);
        	$I->see('Not Found:');
    	}

	public function albumSetCaptionForNotFoundImage(\FunctionalTester $I)
    	{
        	$I->amLoggedInAs(\app\models\UserIdentity::findByUsername('root'));
       		$I->amOnRoute('admin/lab/update', ['id' => 10000]);
        	$I->see('Not Found: ');
    	}

}