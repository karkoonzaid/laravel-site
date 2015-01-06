<?php namespace Acme\Payment;

use Acme\Core\BaseRepository;
use Payment;

class PaymentRepository extends BaseRepository {

    public $paymentMethds = ['paypal'];

    /**
     * @param Payment $model
     */
    public function __construct(Payment $model)
    {
        $this->model = $model;
    }

    public function findByToken($token)
    {
        return $this->model->where('token',$token)->first();
    }

    public function findByTransaction($transactionID)
    {
        return $this->model->where('transaction_id',$transactionID)->first();
    }

}