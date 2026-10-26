# Platon Integration Changelog

## 3.5.0
- Pass an uppercase `POST` method to Guzzle in [Credit\Client](./src/Credit/Client.php):
guzzlehttp/guzzle 7.11+ deprecates lowercase methods, Guzzle 8 will send them as is.
- Drop guzzlehttp/guzzle 6 support, require `^7.4.5`.
- Fail tests on deprecations, including the ones silenced by `trigger_deprecation()`.

## 3.4.0
- Add [DirectDebit\Client](./src/DirectDebit/Client.php) for recurring charges (SALE by card token),
sends `ext3=recurring` and `channel_id=rec` to route charges to Platon recurring terminal.
- Update squizlabs/php_codesniffer to ^4.0 to support PHP 8.4 interface properties.

## 3.3.0
- Add [Payment\PayerDetails](./src/Payment/PayerDetails.php) interface with additional taxNumber and agreementNumber fields.

## 3.2.0
- Update PHP to 8.4, fix compatibility issues (library Ekman/luhn-algorithm [needs upgrade](https://github.com/Ekman/luhn-algorithm/issues/43))
- Add [Credit\Transfer\RecipientInformation](./src/Credit/Transfer/RecipientInformation.php) interface with readonly
agreementNumber, taxNumber, firstName, lastName properties to match new Platon API.

## 3.0.0
- Migrate to [wearesho-team/bobra-payments 3.0](https://github.com/wearesho-team/bobra-payments/releases/tag/3.0.0)
- Update PHP to 8.1, fix compatibility issues (null to \strrev)
- Update nekman/luhn-algorithm to ^5.0

## 2.0.0
- Migrate to [wearesho-team/bobra-payments 2.0](https://github.com/wearesho-team/bobra-payments/releases/tag/2.0.0)
- Add support for first_name, last_name, email, phone payment parameters
- Change [Client](./src/Client.php) implementation to support *PayerDetailsInterface* argument

## 1.13.3
- Fix handling extX (where X > 4) in [Notification\Server](./src/Notification/Server.php)

## 1.5.0 - 10 Jule, 2018
- Add timezone to Notification payments date

## 1.4.0 - 2 Jule, 2018
- Bobra Payments 1.5.0 support (exceptions)

## 1.3.0 - 20 June, 2018
- Split *Payment* class into [Payment\CC](./src/Payment/CC.php) and [Payment\C2A](./src/Payment/C2A.php) classes
- Modify Client to generate CC and C2A payments depending on configuration
(\InvalidArgumentException will be thrown if no type not match both *CC* and *C2A*)

## 1.2.0 - 11 June, 2018
- Add [Credit](./src/Credit) classes, that describes transfer funds to client credit card.
It should be used for issuing credits. 
- Add [Notification\Server](./src/Notification/Server.php) for handling platon callbacks

## 1.1.0 - 16 April, 2018
- Add [TransactionInterface](./src/TransactionInterface.php) with implementation:
 [TransactionTrait](./src/TransactionTrait.php), [Transaction](./src/Transaction.php).
 This interface contains FormId field, that will be used in [Client](./src/Client.php) for payment
 form id instead of Payments\Transaction getType()
