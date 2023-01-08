<?php


namespace backend\tests\Unit;

use backend\tests\UnitTester;
use common\models\Flight;
use common\models\Airplane;
use common\models\Airport;

class FlightTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // * * *TESTS* * *

    public function testValidation()
    {
        $flight = new Flight();

        // test Flight

        // Departure Date

        $flight->setDepartureDate(null);
        $this->assertFalse($flight->validate(['departureDate']));

        $flight->setDepartureDate('07-01-2022');
        $this->assertFalse($flight->validate(['departureDate']));

        $flight->setDepartureDate('2023-01-06');
        $this->assertFalse($flight->validate(['departureDate']));

        $flight->setDepartureDate('abc');
        $this->assertFalse($flight->validate(['departureDate']));

        $flight->setDepartureDate('2022/10/10 10:30:00');
        $this->assertTrue($flight->validate(['departureDate']));

        // Duration

        $flight->setDuration(null);
        $this->assertFalse($flight->validate(['duration']));

        $flight->setDuration('abc');
        $this->assertFalse($flight->validate(['duration']));

        $flight->setDuration('00:00.1');
        $this->assertFalse($flight->validate(['duration']));

        $flight->setDuration('00:00:01');
        $this->assertTrue($flight->validate(['duration']));

        // Airport Departure

        //TODO: VERIFICAR SE OS AIRPORTS NÃO SÃO ESCOLHIDOS EM DUPLICADO

        $flight->airportDeparture_id = null;
        $this->assertFalse($flight->validate(['airportDeparture_id']));

        $flight->airportDeparture_id = 'Lisboa';
        $this->assertFalse($flight->validate(['airportDeparture_id']));

        $flight->airportDeparture_id = 7;
        $this->assertTrue($flight->validate(['airportDeparture_id']));

        // Airport Arrival

        $flight->airportArrival_id = null;
        $this->assertFalse($flight->validate(['airportArrival_id']));

        $flight->airportArrival_id = 'Lisboa';
        $this->assertFalse($flight->validate(['airportArrival_id']));

        $flight->airportArrival_id = 7;
        $this->assertTrue($flight->validate(['airportArrival_id']));

        // Airplane

        $flight->setAirplane(null);
        $this->assertFalse($flight->validate(['airplane_id']));

        $flight->setAirplane('abc');
        $this->assertFalse($flight->validate(['airplane_id']));

        $flight->setAirplane(3);
        $this->assertTrue($flight->validate(['airplane_id']));
    }
    public function testCRUD()
    {
        //Create airport entries on database

        //Entry 1
        $airportDeparture = new Airport();
        $airportDeparture->country = 'Portugal';
        $airportDeparture->code = 'PT';
        $airportDeparture->city = 'Porto';
        $airportDeparture->search = 95;
        $airportDeparture->status = 'Operational';
        $airportDeparture->save();

        //Entry 2    
        $airportArrival = new Airport();
        $airportArrival->country = 'Russia';
        $airportArrival->code = 'RU';
        $airportArrival->city = 'St.PetersBurg';
        $airportArrival->search = 30;
        $airportArrival->status = 'Operational';
        $airportArrival->save();

        //Create airplane entry on database
        $airplane = new Airplane();
        $airplane->luggageCapacity = 20;
        $airplane->minLinha = 1;
        $airplane->minCol = 'A';
        $airplane->maxLinha = 6;
        $airplane->maxCol = 'F';
        $airplane->economicStart = 'A';
        $airplane->economicStop = 'B';
        $airplane->normalStart = 'C';
        $airplane->normalStop = 'D';
        $airplane->luxuryStart = 'E';
        $airplane->luxuryStop = 'F';
        $airplane->status = 'Active';
        $airplane->save();

        //Create flight entry on database
        $flight = new Flight();
        $flight->departureDate = '2024/01/07 15:30:00';
        $flight->duration = '00:00:00';
        $flight->airportDeparture_id = $airportDeparture->id;
        $flight->airportArrival_id = $airportArrival->id;
        $flight->status = 'Available';
        $flight->airplane_id = $airplane->id;
        $flight->save();

        // read test
        $this->tester->seeRecord('common\models\Flight', ['id' => $flight->id]);

        // update test
        $flight = $this->tester->grabRecord('common\models\Flight', ['id' => $flight->id]);
        $flight->setAttribute('status', 'Complete');

        $flight->save();

        // update nao esta a funcionar
        $this->tester->dontSeeRecord('common\models\Flight', ['status' => 'Complete']);
        $this->tester->seeRecord('common\models\Flight', ['status' => 'Available']);

        // delete test
        $flight->delete();
        $this->tester->dontSeeRecord('common\models\Flight', ['id' => $flight->id]);
    }
}
