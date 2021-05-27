<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * This is the model class for table "images".
 *
 * @property string $image
 */
class Image extends Model
{
    public $image;

    public function rules(){
	return[
	    [['image'], 'required'],
	    [['image'], 'file', 'extensions' => 'jpg,png']
	];
    }

    public function uploadFile(UploadedFile $file){
	$this->image = $file;
	$filename = strtolower(md5(uniqid($file->baseName)) . '.' . $file->extension);
        $file->saveAs('/home/02/iermolae/public_html/web2/lab5/basic1/basic/web/uploads/' . $filename);
	return $filename;          
    }


    public function deleteCurImage($curImage){
	if(!empty($curImage) && $curImage != null && file_exists('/home/02/iermolae/public_html/web2/lab5/basic1/basic/web/uploads/' . $curImage))
	{
	    return unlink('/home/02/iermolae/public_html/web2/lab5/basic1/basic/web/uploads/' . $curImage);
	    //return true;
	}
	return false;
    }

}
