# Authorization

An authorization is a kind of transaction that reserves the balance of the credit card.

## Before start

Before start is highly recommended to read the [20 seconds tutorial](https://github.com/hgflima/rede-acquiring)

## Doing an authorization

To do an authorization use the code

```php
# just choose that is a credit transaction
$transaction = $acquirer->fetch(TransactionType::CREDIT);

# setup the data to send to the service
$data = array('credit_card' => '4242424242424242',
              'exp_month'   => 5,
              'exp_year'    => 2015,
              'cvv'         => "123",
              'amount'      => '1050',
              'reference'   => '1234',
              'capture'     => true);

# do the transaction
$response = $transaction->authorize($data);
print_r($response);
```

## Card holder data

Use the following table to send the right fields to the service

Field Name | Description | Required
---------- | ----------- | --------
credit_card | The number of credit card | yes
exp_month | The month of the credit card expiration date | yes
exp_year | The year of the credit card expiration date | yes
cvv | The security code of the credit card | no
amount | The amount of the transaction without decimal | yes
reference | The order id of the store | yes
capture | Boolean that indicates if the transaction have to be automatic captured | no

## Response

The fields below will be returned when you call authorize method

Field Name | Description | Always
---------- | ----------- | ------
return_code | The return code of this transaction | Yes
message | Error / Success Message | Yes
tid | Transaction ID | Yes
nsu | Unique Sequential Number | Yes
authorization_number | Authorization Number | Yes
reference | The order id of the store | Yes
installments_amount | Amount of the installments | No
interest_rate | Interest rate | No
total_interest_rate | Total interest rate | No
cet | Total cost of this payment | No

## The correct use of reference field

The reference field is used to help find the transactions. Normally it is used to link the order of the store and the transaction. You just can send more than one transaction with the same reference if no transactions was approved (return_code = 0). If you send the same reference of a approved transaction you will receive an error.
