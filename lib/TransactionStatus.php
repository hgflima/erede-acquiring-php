<?php

namespace ERede\Acquiring;

abstract class TransactionStatus {

  const SUCCESS                   = 0;
  const VALIDATION_ERROR          = 1;
  const TRANSACTION_NOT_PROCESSED = 2;
  const TRANSACTION_NOT_APPROVED  = 3;

}
