<?php

use Acme\Payment\PaymentRepository;
use Acme\Subscription\SubscriptionRepository;

class AdminPaymentsController extends AdminBaseController {

    /**
     * @var PaymentRepository
     */
    private $paymentRepository;
    /**
     * @var SubscriptionRepository
     */
    private $subscriptionRepository;


    /**
     * @param PaymentRepository $paymentRepository
     * @param SubscriptionRepository $subscriptionRepository
     */
    function __construct(PaymentRepository $paymentRepository, SubscriptionRepository $subscriptionRepository)
    {
        $this->paymentRepository = $paymentRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        parent::__construct();
    }

    public function index()
    {
        $status = Input::get('status');
        $type   = Input::get('type');

        if ( !isset($type) ) {
            $type = 'payment';
        }

        if ( $type == 'payment' ) {
            if ( isset($status) ) {
                $payments = $this->paymentRepository->getAllByStatus($status, ['user', 'payable.event']);
            } else {
                $payments = $this->paymentRepository->getAll(['user', 'payable.event']);
            }
        } else {
            // refunds
            dd('Not Yet Implemented');
        }

        $this->render('admin.payments.index', compact('payments', 'type','status'));
    }

}

