<?php

namespace backend\models;

use Yii;

use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "{{%home_post}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $tags
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class AdminSession extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
                return '{{%admin_session}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [ 
                [['session_token'], 'safe'],
              [['id','session_id'], 'integer'],];
    }

    
}
