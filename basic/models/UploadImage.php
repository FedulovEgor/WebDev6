<?php
 
namespace app\models;
 
use yii\base\Model;
use yii\web\UploadedFile;
 
class UploadImage extends Model{
 
    public $image;
 
    public function rules(){
        return[
            [['image'], 'required'],
            [['image'], 'file', 'extensions' => 'png, jpg'],
        ];
    }
 
    public function upload(){
        if($this->validate()){
             $this->image->saveAs("/home/02/iermolae/public_html/web2/lab5/basic1/basic/web/uploads/{$this->image->baseName}.{$this->image->extension}");
        }else{
            return false;
        }
	return true;
    }
 
}