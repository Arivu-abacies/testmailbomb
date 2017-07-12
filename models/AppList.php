<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tshirt_app".
 *
 * @property integer $id
 * @property string $name
 * @property string $link
 * @property string $description
 * @property string $image_link
 * @property string $created_date
 */
class AppList extends \yii\db\ActiveRecord
{
	public $dulpicate_image;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tshirt_app';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'link', 'description', 'image_link'], 'required'],
            [['link', 'description'], 'string'],
			[['image_link'], 'file','extensions' => 'jpg,png', 'skipOnEmpty' => true],
            [['created_date'], 'safe'],
			[['dulpicate_image'], 'safe'],
            [['name'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'link' => 'Link',
            'description' => 'Description',
            'image_link' => 'Image Link',
            'created_date' => 'Created Date',
        ];	
    }
	
	public function uploadImage(){
			$this->image_link->saveAs('uploads/' .$this->image_link->baseName. '.' .$this->image_link->extension);
			$this->image_link = 'uploads/'.$this->image_link->baseName.'.'.$this->image_link->extension;
			return true;
	}
	
}
