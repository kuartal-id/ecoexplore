<?php

namespace App\Services\Payments;

use RuntimeException;

/** A gateway reported a paid amount that differs from the booking's amount_idr. */
class PaymentAmountMismatch extends RuntimeException {}
