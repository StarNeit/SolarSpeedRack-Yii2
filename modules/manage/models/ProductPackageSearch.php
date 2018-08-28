<?php

namespace app\modules\manage\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProductPackage;

/**
 * ProductPackageSearch represents the model behind the search form about `app\models\ProductPackage`.
 */
class ProductPackageSearch extends ProductPackage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sale_id', 'required_id', 'sale_type', 'required_qty', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['sale_percent'], 'number'],
            [['sale_amount', 'code', 'sale_start', 'sale_end'], 'safe'],
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
    public function search($params, $cc = '0')
    {
        $query = ProductPackage::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'is_coupon' => $cc,
            'sale_id' => $this->sale_id,
            'required_id' => $this->required_id,
            'sale_type' => $this->sale_type,
            'sale_percent' => $this->sale_percent,
            'required_qty' => $this->required_qty,
            'sale_start' => $this->sale_start,
            'sale_end' => $this->sale_end,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code]);
        $query->andFilterWhere(['like', 'sale_amount', $this->sale_amount]);

        return $dataProvider;
    }
}
