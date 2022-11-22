<?php

use common\models\Airport;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use backend\helpers\TableBuilder;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Airports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="airport-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Airport', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    $headers = [
        [
            'label' => '#',
            'attr' => 'id',
            'class' => 'col-2 text-start',
        ],
        [
            'label' => 'Country',
            'attr' => 'country',
            'class' => 'col text-center',
        ],
        [
            'label' => 'Code',
            'attr' => 'code',
            'class' => 'col text-center',
        ],
        [
            'label' => 'City',
            'attr' => 'city',
            'class' => 'col text-center',
        ],
        [
            'label' => 'Search',
            'attr' => 'search',
            'class' => 'col text-end',
        ],
    ];
    $tableBuilder = new TableBuilder($headers, $model);
    $tableBuilder->generate();
    ?>



</div>