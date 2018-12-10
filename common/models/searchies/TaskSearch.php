<?php

namespace common\models\searchies;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Task;

/**
 * common\models\searchies\TaskSearch represents the model behind the search form about `common\models\Task`.
 */
 class TaskSearch extends Task
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'manager_id', 'executor_id'], 'integer'],
            [['name', 'comment', 'link_lecture', 'file', 'status', 'created_at', 'updated_at'], 'safe'],
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
        $query = Task::find();

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
            'manager_id' => $this->manager_id,
            'executor_id' => $this->executor_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'link_lecture', $this->link_lecture])
            ->andFilterWhere(['like', 'file', $this->file])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
