<?php

namespace app\modules\manage\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PvModel;

/**
 * PvModelSearch represents the model behind the search form about `app\models\PvModel`.
 */
class PvModelSearch extends PvModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'manufacturer_id'], 'integer'],
            [['name', 'cell_type'], 'safe'],
            [['power', 'length', 'width', 'depth'], 'number'],
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
        $query = PvModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'manufacturer_id' => $this->manufacturer_id,
            'power' => $this->power,
            'length' => $this->length,
            'width' => $this->width,
            'depth' => $this->depth,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'cell_type', $this->cell_type]);

        return $dataProvider;
    }
}
