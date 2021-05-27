<?php
namespace models;
use app\fixtures\ImagesFixture;
use app\models\UploadImage;
use yii\web\UploadedFile;

class UploadImageTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $upload;
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

    public function returnFile($filename, $filetype, $filesize)
    {
	$image = new UploadedFile([
	    'name' => $filename,
	    'tempName' => codecept_data_dir() . $filename,
	    'type' => $filetype,
	    'size' => $filesize]);

	$from = "/home/02/iermolae/public_html/web2/lab5/basic1/basic/web/uploads/{$image->baseName}.{$image->extension}";
	$to = "/home/02/iermolae/public_html/web2/lab5/basic1/basic/tests/_data/{$image->baseName}.{$image->extension}";
	rename($from, $to);

    }


    // tests
    public function testUploadCorrectJpg()
    {
	$i = new UploadedFile([
	    'name' => 'test_1.jpg',
	    'tempName' => codecept_data_dir() . 'test_1.jpg',
	    'type' => 'image/jpg',
	    'size' => 44*1024]);

	$this->upload = new UploadImage([
	    'image' => $i,
	]);
	expect_that($this->upload->validate());
	expect_that($this->upload->upload());

	$this->returnFile('test_1.jpg', 'image/jpg', 44*1024);
    }

    public function testUploadCorrectPng()
    {
	$i = new UploadedFile([
	    'name' => 'test_2.png',
	    //'tempName' => '/home/02/iermolae/public_html/web2/lab5/basic1/basic/tests/_data/test_2.png',
	    'tempName' => codecept_data_dir() . 'test_2.png',
	    'type' => 'image/png',
	    'size' => 223*1024]);

	$this->upload = new UploadImage([
	    'image' => $i,
	]);
	expect_that($this->upload->validate());
	expect_that($this->upload->upload());
	
	$this->returnFile('test_2.png', 'image/png', 223*1024);

    }

    public function testUploadCorrectTxt()
    {
	$i = new UploadedFile([
	    'name' => 'test_3.txt',
	    'tempName' => codecept_data_dir() . 'test_3.txt',
	    'type' => 'image/txt',
	    'size' => 1024]);

	$this->upload = new UploadImage([
	    'image' => $i,
	]);
	expect_not($this->upload->validate());
	expect_not($this->upload->upload());
	
    }


}