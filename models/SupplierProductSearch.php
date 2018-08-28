<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;

/**
 * SupplierProductSearch represents the model behind the search form about `app\models\Product`.
 */
class SupplierProductSearch extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'category_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['name', 'manufacturer_product_code', 'msrp', 'nmfc', 'package_type', 'pdf', 'cad', 'youtube'], 'safe'],
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
    public function search($params, $companyId)
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
            'id' => $this->id,
            'company_id' => $companyId,
            'category_id' => $this->category_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'manufacturer_product_code', $this->manufacturer_product_code])
            ->andFilterWhere(['like', 'msrp', $this->msrp])
            ->andFilterWhere(['like', 'nmfc', $this->nmfc])
            ->andFilterWhere(['like', 'package_type', $this->package_type])
            ->andFilterWhere(['like', 'pdf', $this->pdf])
            ->andFilterWhere(['like', 'cad', $this->cad])
            ->andFilterWhere(['like', 'youtube', $this->youtube]);

        return $dataProvider;
    }
}
