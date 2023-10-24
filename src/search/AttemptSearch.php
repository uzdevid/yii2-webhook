<?php

namespace uzdevid\webhook\search;

use uzdevid\webhook\models\Attempt;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AttemptSearch represents the model behind the search form of `uzdevid\webhook\models\Attempt`.
 */
class AttemptSearch extends Attempt {
    /**
     * {@inheritdoc}
     */
    public function rules(): array {
        return [
            [['id', 'hook_id', 'attempt', 'status'], 'integer'],
            [['event_name', 'event_time', 'method', 'url', 'payload', 'response', 'create_time', 'job_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
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
    public function search($params) {
        $query = Attempt::find();

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
            'hook_id' => $this->hook_id,
            'attempt' => $this->attempt,
            'event_time' => $this->event_time,
            'status' => $this->status,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['ilike', 'event_name', $this->event_name])
            ->andFilterWhere(['ilike', 'method', $this->method])
            ->andFilterWhere(['ilike', 'url', $this->url])
            ->andFilterWhere(['ilike', 'payload', $this->payload])
            ->andFilterWhere(['ilike', 'response', $this->response]);

        $query->orderBy(['id' => SORT_DESC]);

        return $dataProvider;
    }

    public function rowOptions(Attempt $model) {
        return match (true) {
            in_array($model->status, [200, 201, 202, 204, 206]) => ['class' => 'table-success'],
            in_array($model->status, [400, 401, 403, 404, 500]) => ['class' => 'table-danger'],
            in_array($model->status, [301, 302, 303, 307, 308]) => ['class' => 'table-warning'],
            default => ['class' => 'table-info'],
        };
    }
}
