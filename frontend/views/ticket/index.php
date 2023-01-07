<?php

use common\models\Ticket;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tickets';
?>
<div class="ticket-index mt-5">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'fName',
            'surname',
            'gender',
            'age',
            'checkedIn',
            //'client_id',
            'flight_id',
            [
                'label' => 'Flight',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->flight->airportDeparture->city . ' - ' . $model->flight->airportArrival->city, ['flight/view', 'id' => $model->flight->airportDeparture_id]);
                }
            ],
            [
                'label' => 'Date',
                'value' => function ($model) {
                    return $model->flight->departureDate;
                }
            ],
            //'seatLinha',
            //'seatCol',
            //'luggage_1',
            //'luggage_2',
            //'receipt_id',
            [
                'class' => ActionColumn::class,
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="fas fa-eye"></i>', $url, [
                            'title' => Yii::t('app', 'View'),
                            'class' => 'btn btn-sm btn-primary',
                        ]);
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view')
                        return Url::to(['view', 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
