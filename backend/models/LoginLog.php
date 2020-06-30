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
class LoginLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
                return '{{%login_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [ 
                [['ip'], 'safe'],
              [['id','user_id','date'], 'integer'],];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {//movie_id,movie_name,movie_code,release_date,version,`session`,total_people,total_bo,bdate
        return [
            'id' => "ID",
            'name'=>"电影名称",
            'release_date'=>"上映日期",
        ];
    }
    public function search($params,$now=0)
    {
        return;
        $query = ZZMovie::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'release_date',

                    
                ],'defaultOrder' => [
                        'release_date' => SORT_DESC,            
                    ]
            ],
        ]);

        $this->load($params);
        if($this->isnew){
            $query->andWhere(" id not in (select zz_id from movie_total)");
        }
        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

   
        $today=date("Y-m-d");
        
        /*if($this->now){
            $query->andFilterWhere([
                    "<=","release_date", $today
                ]);
            $query->andFilterWhere([
                    ">=","release_date", $today
                ]);
        }*/
        $query->andFilterWhere([
                    "=","release_date",  $this->release_date
                ]);
        $query->andFilterWhere(['=', 'id', $this->id]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        
        return $dataProvider;
    }
    
}
