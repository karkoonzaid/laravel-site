<?php
namespace Kuwaitii\Subscription\State;

use Acme\Subscription\State\Approved;
use Acme\Subscription\State\Pending;
use Acme\Subscription\State\Subscriber;
use TestCase;

class SubscriberTest extends TestCase {

    public function testClassSetsCorrectStatusWithParam() {

        $class = new Subscriber('APPROVED');
        $expects= new Approved();
        $this->assertEquals($expects,$class->subscriptionState);
    }

    public function testClassSetsPendingStateWithoutParams(){
        $class = new Subscriber();
        $expects = new Pending();
        $this->assertEquals($expects,$class->subscriptionState);
    }

    public  function testConfirmedClassDoesNotAllowSubscription(){
        $class = new Subscriber('CONFIRMED');
        $actual  = $class->subscribe(1,1,1);
        $this->expectOutputString('already subscribed',$actual);
    }

    public  function testConfirmedClassAllowsUnsubscription(){
        $class = new Subscriber('CONFIRMED');
        $actual  = $class->unsubscribe(1);
        $this->expectOutputString('unsubscribed',$actual);
    }

}
 