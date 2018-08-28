<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\controllers\user;

use yii\web\NotFoundHttpException;

use dektrium\user\controllers\ProfileController as BaseProfileController;

/**
 * ProfileController shows users profiles.
 *
 * @property \dektrium\user\Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class ProfileController extends BaseProfileController
{
    /**
     * Shows user's profile.
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex()
    {
        $profile = $this->finder->findProfileById(\Yii::$app->user->getId());

        if ($profile === null) {
            throw new NotFoundHttpException;
        }

        return $this->render('show', [
            'profile' => $profile,
        ]);
    }

    /**
     * Shows user's profile.
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionShow()
    {
        throw new NotFoundHttpException;
    }
}
