<?php

namespace app\modules\manage\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EmailConfig;

/**
 * EmailConfigSearch represents the model behind the search form about `app\models\EmailConfig`.
 */
class EmailConfigSearch extends EmailConfig
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'default'], 'integer'],
            [['from_name', 'from_email', 'replyto_name', 'replyto_email', 'cc_emails'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = EmailConfig::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'default' => $this->default,
        ]);

        $query->andFilterWhere(['like', 'from_name', $this->from_name])
            ->andFilterWhere(['like', 'from_email', $this->from_email])
            ->andFilterWhere(['like', 'replyto_name', $this->replyto_name])
            ->andFilterWhere(['like', 'replyto_email', $this->replyto_email])
            ->andFilterWhere(['like', 'cc_emails', $this->cc_emails]);

        return $dataProvider;
    }
}
