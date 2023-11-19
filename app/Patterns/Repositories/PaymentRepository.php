<?php

namespace App\Patterns\Repositories;

use App\Http\Resources\Payments\PaymentResource;
use App\Models\Payment;

/**
 * Class UserRepository.
 *
 * @package namespace App\Repositories;
 */
class PaymentRepository extends BaseRepository
{
    function __construct()
    {
        $this->makeModel();
        $this->skipPresenter(false);
        $this->setPresenter(PaymentResource::class);
    }
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Payment::class;
    }
}
