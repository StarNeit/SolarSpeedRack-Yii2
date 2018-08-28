<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProjectDetails;

/**
 * ProjectDetailsSearch represents the model behind the search form about `app\models\ProjectDetails`.
 */
class ProjectDetailsSearch extends ProjectDetails
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'project_id', 'customer_id', 'installer_id', 'installation_status', 'inspection_time', 'installation_time', 'inspection_status', 'customer_confirmation', 'permit_plan_status', 'products_shipped', 'completion_form_submitted', 'permit_plan_id'], 'integer'],
            [['inspection_date',  'installation_status', 'inspection_detail', 'installation_date', 'installation_detail'], 'safe'],
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
        $query = ProjectDetails::find();

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
            'project_id' => $this->project_id,
            'customer_id' => $this->customer_id,
            'installer_id' => $this->installer_id,
            'inspection_date' => $this->inspection_date,
            'inspection_time' => $this->inspection_time,
            'installation_date' => $this->installation_date,
            'installation_time' => $this->installation_time,
            'installation_status' => $this->installation_status,
            'inspection_status' => $this->inspection_status,
            'customer_confirmation' => $this->customer_confirmation,
            'permit_plan_status' => $this->permit_plan_status,
            'products_shipped' => $this->products_shipped,
            'completion_form_submitted' => $this->completion_form_submitted,
            'permit_plan_id' => $this->permit_plan_id,
        ]);

        $query->andFilterWhere(['like', 'inspection_detail', $this->inspection_detail])
            ->andFilterWhere(['like', 'installation_detail', $this->installation_detail]);

        return $dataProvider;
    }
}
