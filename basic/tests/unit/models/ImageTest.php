<?php
namespace models;

use app\fixtures\ImagesFixture;
use app\models\Image;
use app\models\Images;
use yii\web\UploadedFile;

class ImageTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $image;
    private $filename;

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

    public function fileReturn()
    {
	$image = new UploadedFile([
	    'name' => 'test_1.jpg',
	    'tempName' => codecept_data_dir() . 'test_1.jpg',
	    'type' => 'image/jpg',
	    'size' => 44*1024]);

	$from = "/home/02/iermolae/public_html/web2/lab5/basic1/basic/tests/_data/{$image->baseName}.{$image->extension}";
	$to = "/home/02/iermolae/public_html/web2/lab5/basic1/basic/tests/_data/{$image->baseName}_1.{$image->extension}";
	copy($from, $to);

    }


    // tests

    public function testUploadFile()
    {
	//$i = new Image();
	//$i->image = '/home/02/iermolae/public_html/web2/lab5/basic1/basic/web/uploads/test.png';
	//$file = UploadedFile::getInstance($i, 'image');

	$im = new UploadedFile([
	    'name' => 'test_1_1.jpg',
	    'tempName' => codecept_data_dir() . 'test_1_1.jpg',
	    'type' => 'image/jpg',
	    'size' => 44*1024]);

	$i = new Image();

	expect_that($fn = $i->uploadFile($im));
	$this->filename = $fn;
	
	$this->fileReturn();
    }

/*
    public function testDeleteCurrentImageFile()
    {
	$im = new Image();
	$file = UploadedFile::getInstanceByName($this->filename);

	expect_that(file_exists('/home/02/iermolae/public_html/web2/lab5/basic1/basic/web/uploads/' . $file));

	expect_that($im->deleteCurImage($file));

    }
*/

    public function testDeleteCurrentImageFileNull()
    {
	$i = new Image();
	expect_that($i->deleteCurImage(null) == false);

    }


}