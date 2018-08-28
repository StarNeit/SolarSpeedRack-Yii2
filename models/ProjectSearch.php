<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Project;

/**
 * ProjectSearch represents the model behind the search form about `app\models\Project`.
 */
class ProjectSearch extends Project
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['name', 'zip_code', 'total_watt', 'total_material', 'cost_per_watt', 'cost_per_panel', 'layout', 'config'], 'safe'],
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
        $query = Project::find();

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
            'module_id' => $this->module_id,
            'inverter_id' => $this->inverter_id,
            'optimizer_id' => $this->optimizer_id,
            'roof_attachment_id' => $this->roof_attachment_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'company_id' => $this->company_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'zip_code', $this->zip_code])
            ->andFilterWhere(['like', 'total_watt', $this->total_watt])
            ->andFilterWhere(['like', 'total_material', $this->total_material])
            ->andFilterWhere(['like', 'cost_per_watt', $this->cost_per_watt])
            ->andFilterWhere(['like', 'cost_per_panel', $this->cost_per_panel])
            ->andFilterWhere(['like', 'layout', $this->layout])
            ->andFilterWhere(['like', 'config', $this->config]);

        return $dataProvider;
    }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchOpen($params)
    {
        $query = Project::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]] 
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'zip_code' => $this->zip_code,
            'total_watts' => $this->total_watt,
            'total_material' => $this->total_material,
            'cost_per_watt' => $this->cost_per_watt,
            'cost_per_panel' => $this->cost_per_panel,
            'created_by' => \Yii::$app->user->identity->id,
            'updated_by' => $this->updated_by,
            'status' => 1,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
    public function searchClosed($params)
    {
        $query = Project::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]] 
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'zip_code' => $this->zip_code,
            'total_watts' => $this->total_watt,
            'total_material' => $this->total_material,
            'cost_per_watt' => $this->cost_per_watt,
            'cost_per_panel' => $this->cost_per_panel,
            'created_by' => \Yii::$app->user->identity->id,
            'updated_by' => $this->updated_by,
            'status' => 2,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
