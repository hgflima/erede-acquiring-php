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
$data = array('credit_card' => '4242424242424242', 'exp_month' => 5, 'exp_year' => 2015, 'cvv' => "123", amount' => '1050', 'capture' => true);

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
amount | The amount of the transaction without decimal | yes
cvv | The security code of the credit card | no
name | The card holder name | no
capture | Boolean that indicates if the transaction have to be automatic captured | yes

