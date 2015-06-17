# Find

Use this method to get the status of a transaction

## Before start

Before start is highly recommended to read the [20 seconds tutorial](https://github.com/hgflima/rede-acquiring)

## Finding a transaction

To find a transaction use the code

```php
# just choose that is a credit transaction
$transaction = $acquirer->fetch(TransactionType::CREDIT);

# setup the data to send to the service
$data = array('reference' => '123456');

# do the transaction
$response = $transaction->find($data);
print_r($response);
```

## Transaction data

Use the following table to send the right fields to the service

Field Name | Description | Required
---------- | ----------- | --------
tid | The transaction id that was returned in the response of the authorize method | no
reference | The order id in the e-commerce store | no

Note: *Neither the fields is required however one of the fields needs to be sent*
