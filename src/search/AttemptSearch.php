<?php

namespace uzdevid\webhook\search;

use uzdevid\webhook\models\Attempt;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AttemptSearch represents the model behind the search form of `uzdevid\webhook\models\Attempt`.
 */
class AttemptSearch extends Attempt {
    public string|null $event_time_from = null;
    public string|null $event_time_to = null;

    public string|null $property_name = null;
    public string|null $property_value = null;

    /**
     * {@inheritdoc}
     */
    public function rules(): array {
        return [
            [['id', 'hook_id', 'attempt', 'status'], 'integer'],
            [['event_name', 'event_time_from', 'event_time_to', 'url', 'job_id', 'property_name', 'property_value'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider {
        $query = Attempt::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->event_time_from) {
            $query->andFilterWhere(['>=', 'event_time', $this->event_time_from]);
        }

        if ($this->event_time_to) {
            $query->andFilterWhere(['<=', 'event_time', $this->event_time_to]);
        }

        if (!is_null($this->property_name) && !is_null($this->property_value)) {
            $query->andWhere(['payload' . $this->property_name, $this->property_value]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'hook_id' => $this->hook_id,
            'attempt' => $this->attempt,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['ilike', 'event_name', $this->event_name])
            ->andFilterWhere(['ilike', 'method', $this->method])
            ->andFilterWhere(['ilike', 'url', $this->url]);

        $query->orderBy(['id' => SORT_DESC]);

        return $dataProvider;
    }

    public function rowOptions(Attempt $model): array {
        return match (true) {
            in_array($model->status, [200, 201, 202, 204, 206]) => ['class' => 'table-success'],
            in_array($model->status, [400, 401, 403, 404, 500]) => ['class' => 'table-danger'],
            in_array($model->status, [301, 302, 303, 307, 308]) => ['class' => 'table-warning'],
            default => ['class' => 'table-info'],
        };
    }
}
