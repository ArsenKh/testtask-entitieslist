<?php

namespace testtask\entitieslist\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use testtask\entitieslist\models\StackOfEntities;

/**
 * EntitySearch represents the model behind the search form about `app\models\Entity`.
 */
class EntitySearch extends StackOfEntities
{
    public $name;
    public $type;
    public $date;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type', 'date'], 'safe'],
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
        $query = StackOfEntities::find();

        // join relation
        $query->joinWith(['entity']);

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

        $query->andFilterWhere(['like', 'entitieslist_entity.name', $this->name])
            ->andFilterWhere(['like', 'entitieslist_entity.type', $this->type])
            ->andFilterWhere(['like', 'created_at', $this->date]);

        return $dataProvider;
    }
}
