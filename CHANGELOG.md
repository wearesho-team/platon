# Platon Integration Changelog

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
