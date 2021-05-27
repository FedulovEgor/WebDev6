<?php
namespace tests\unit\models;

use app\fixtures\ImagesFixture;
use app\models\Images;

class Images1Test extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $im;

    public function _before()
    {
	$this->tester->haveFixtures([
            'users' => [
            	'class' => ImagesFixture::className(),
            	'dataFile' => codecept_data_dir() . 'images.php'
            ],
    	]);
    }


    protected function _after()
    {
    }

    // tests

    public function testSaveImage()
    {
	$i = $this->tester->grabFixture('users', 'image2');
	expect_that($i->saveImage($i->name));
	expect($i->name)->equals('test.png');
    }

    public function testGetImageNull()
    {
	$i = $this->tester->grabFixture('users', 'image1');
	expect_that($path = $i->getImage());
	expect($path)->equals('http://kappa.cs.petrsu.ru/~iermolae/web2/lab5/basic1/basic/web/uploads/noimage.png');
    }

    public function testGetImageNotnull()
    {
	$i = $this->tester->grabFixture('users', 'image2');
	expect($i->name)->equals('test.png');
	expect_that($path = $i->getImage());
	expect($path)->equals('http://kappa.cs.petrsu.ru/~iermolae/web2/lab5/basic1/basic/web/uploads/test.png');

    }

    public function testDeleteImage()
    {
	//$i = $this->tester->grabFixture('users', 'image2');
	//expect($i->name)->equals('test.png');
	//expect_that($i->name = 'test1.png');
	//expect($i->name)->equals('test1.png');
	$im = Images::findOne(10);
	expect_that($im->deleteImage());

    }



    
}
