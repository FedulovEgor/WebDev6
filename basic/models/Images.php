<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "images".
 *
 * @property int $id
 * @property string $name
 * @property string|null $caption
 */
class Images extends \yii\db\ActiveRecord
{
	public $image;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'caption'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'caption' => 'Caption',
        ];
    }

    public function saveImage($filename){
        $this->name = $filename;
	return $this->save(false);
    }

    public function deleteImage()
    {
	$i = new Image;
	$i->deleteCurImage($this->name);
	return true;
    }

    public function getImage()
    {
	if($this->name && file_exists('/home/02/iermolae/public_html/web2/lab5/basic1/basic/web/uploads/' . $this->name))
	{
	    return 'http://kappa.cs.petrsu.ru/~iermolae/web2/lab5/basic1/basic/web/uploads/' . $this->name;
	}
	return 'http://kappa.cs.petrsu.ru/~iermolae/web2/lab5/basic1/basic/web/uploads/noimage.png';
    }

    public function beforeDelete()
    {
	$this->deleteImage();

	return parent::beforeDelete();
    }

}
