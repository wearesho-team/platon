# Platon Integration Changelog

## 1.3.0 - 20 June, 2017
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
