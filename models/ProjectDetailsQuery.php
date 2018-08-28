<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ProjectDetails]].
 *
 * @see ProjectDetails
 */
class ProjectDetailsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ProjectDetails[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProjectDetails|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
