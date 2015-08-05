# Cancel

Use this method to get the cancel the transaction in the same day

## Before start

Before start is highly recommended to read the [20 seconds tutorial](https://github.com/hgflima/rede-acquiring)

## Finding a transaction

To transaction a transaction use the code

```php
# just choose that is a credit transaction
$transaction = $acquirer->fetch(TransactionType::CREDIT);

# setup the data to send to the service
$data = array('tid' => '123456');

# do the transaction
$response = $transaction->cancel($data);
print_r($response);
```

## Request Data

Use the following table to send the right fields to the service

Field Name | Description | Required
---------- | ----------- | --------
tid | The transaction id that was returned in the response of the authorize method | yes


