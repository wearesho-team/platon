# Platon Integration Changelog
 
## 1.2.0 - ?
- Add [Credit](./src/Credit) classes, that describes transfering funds to client credit card.
It should be used for issuing credits. 
- Add [notification server](./src/Notification/Server.php) for handling platon requests

## 1.1.0 - 16 April, 2018
- Add [TransactionInterface](./src/TransactionInterface.php) with implementation:
 [TransactionTrait](./src/TransactionTrait.php), [Transaction](./src/Transaction.php).
 This interface contains FormId field, that will be used in [Client](./src/Client.php) for payment
 form id instead of Payments\Transaction getType()
