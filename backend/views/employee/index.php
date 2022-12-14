<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;


/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Employees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-index">

    <div class="d-flex m-2 justify-content-end">
        <?= Html::a('+ Create Employee', ['create'], ['class' => 'btn btn-dark']) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'label' => 'Full Name',
                'value' => function ($model) {
                    return (isset($model->userData->fName) ? $model->userData->fName : 'Not set') . '   ' . (isset($model->userData->surname) ? $model->userData->surname : 'Not set');
                }
            ],
        [
            'label' => 'Email',
            'value' => function ($model) {
                return isset($model->email) ? $model->email : "Not set";
            }
        ],
            [
                'label' => 'Phone',
                'value' => function ($model) {
                    return isset($model->userData->phone) ? $model->userData->phone : "Not set";
                }],
            [
                'label' => 'Gender',
                'value' => function ($model) {
                    return isset($model->userData->gender) ? ($model->userData->gender = 'M' ? 'Male' : 'Female') : "Not set";
                }
            ],
            [
                'label' => 'Role',
                'value' => function ($model) {
                    return isset($model->authAssignment->item_name) ? $model->authAssignment->item_name : "Not set";
                }
            ],
            [
                'label' => 'Salary',
                'value' => function ($model) {
                    return isset($model->employee->salary) ? $model->employee->salary . '€' : "Not set";
                }
            ],
            [
                'label' => 'Airport',
                'value' => function ($model) {
                    return isset($model->employee->airport) ? $model->employee->airport->country . ' - ' . $model->employee->airport->city : "Not set";
                }
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="fas fa-eye"></i>', $url, [
                            'title' => Yii::t('app', 'View'),
                            'class' => 'btn btn-sm btn-primary',
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<i class="fas fa-edit"></i>', $url, [
                            'title' => Yii::t('app', 'Update'),
                            'class' => 'btn btn-sm btn-primary',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="fas fa-trash"></i>', $url, [
                            'title' => Yii::t('app', 'Delete'),
                            'class' => 'btn btn-sm btn-danger',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        return Url::to(['view', 'user_id' => $model->id]);
                    }
                    if ($action === 'update') {
                        return Url::to(['update', 'user_id' => $model->id]);
                    }
                    if ($action === 'delete') {
                        return Url::to(['delete', 'user_id' => $model->id]);
                    }
                }
            ],
        ],
    ]); ?>



</div>
