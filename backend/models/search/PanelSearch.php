<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Panel;

/**
 * PanelSearch represents the model behind the search form of `common\models\Panel`.
 */
class PanelSearch extends Panel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'port'], 'integer'],
            [['adminName', 'userName', 'site', 'type', 'ipAddress'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Panel::find();

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
            'port' => $this->port,
        ]);

        $query->andFilterWhere(['like', 'adminName', $this->adminName])
            ->andFilterWhere(['like', 'userName', $this->userName])
            ->andFilterWhere(['like', 'site', $this->site])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'ipAddress', $this->ipAddress]);

        return $dataProvider;
    }
}
