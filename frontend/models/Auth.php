<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * ContactForm is the model behind the contact form.
 */
class Auth extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%auth}}';
    }

    public static function findByUserId($id)
    {
        return static::findOne(['user_id' => $id])->toArray();
    }
}