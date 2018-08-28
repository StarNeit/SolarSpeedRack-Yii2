<?php

namespace app\modules\manage\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;

/**
 * ProductSearch represents the model behind the search form about `app\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'hazardous', 'created_by', 'available_stock', 'created_at', 'updated_at', 'status'], 'integer'],
            [['name', 'features', 'com', 'manufacturer_product_code', 'msrp', 'nmfc', 'package_type', 'pdf', 'cad', 'youtube', 'class', 'commodity_type', 'content_type'], 'safe'],
            [['rating'], 'number'],
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
        $query = Product::find();

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
            'product.id' => $this->id,
            'category_id' => $this->category_id,
            'rating' => $this->rating,
            'available_stock' => $this->available_stock,
            'hazardous' => $this->hazardous,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'product.name', $this->name])
            ->andFilterWhere(['like', 'features', $this->features])
            ->andFilterWhere(['like', 'manufacturer_product_code', $this->manufacturer_product_code])
            ->andFilterWhere(['like', 'msrp', $this->msrp])
            ->andFilterWhere(['like', 'nmfc', $this->nmfc])
            ->andFilterWhere(['like', 'package_type', $this->package_type])
            ->andFilterWhere(['like', 'pdf', $this->pdf])
            ->andFilterWhere(['like', 'cad', $this->cad])
            ->andFilterWhere(['like', 'youtube', $this->youtube])
            ->andFilterWhere(['like', 'class', $this->class])
            ->andFilterWhere(['like', 'commodity_type', $this->commodity_type])
            ->andFilterWhere(['like', 'content_type', $this->content_type]);

        return $dataProvider;
    }
}
