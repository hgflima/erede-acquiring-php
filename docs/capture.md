# Capture

A capture is a confirmation of a transaction. After this transaction the balance of the credit card will be sensitized.

## Before start

Before start is highly recommended to read the [20 seconds tutorial](https://github.com/hgflima/rede-acquiring)

## Doing a capture

To do a capture use the code

```php
# just choose that is a credit transaction
$transaction = $acquirer->fetch(TransactionType::CREDIT);

# setup the data to send to the service
$data = array('tid' => '123456', 'installments' => 2, 'amount' => '1050');

# do the transaction
$response = $transaction->capture($data);
print_r($response);
```

## Card holder data

Use the following table to send the right fields to the service

Field Name | Description | Required
---------- | ----------- | --------
tid | The transaction id that was returned in the response of the authorize method | yes
installments | The number of installments | yes
amount | The amount of the transaction without decimal | yes

