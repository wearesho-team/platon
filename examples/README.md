# Examples

## Info
Fetching information about account balance.
You can use file [info.php](./info.php) to use it in cli mode:

```bash
./examples/info.php
```

It will ask for private and public keys for this API
and fetch all info and displays it in JSON and string 
representations.  
*See [Info\Response](../src/Info/Response.php) for details*

```
Public Key: XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
Private Key: XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
[
    {
        "lastOperation": "2018-11-22 11:00:00",
        "id": "00000-project",
        "account": 00000000000000,
        "type": 1,
        "outcome": 1000,
        "balance": 10000
    }
]

************PRIVAT************
Ключ = 00000-project
Остаток = 10000
Транзитный счет = 00000000000000
Дата/время последней операции = 2018-11-22 11:00:00
Выплачено = 1000
```
