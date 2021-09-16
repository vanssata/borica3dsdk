# WIP - DEPRECATED this script need changes to sing and form
----
## Requirements

- PHP >= 7.2 (including 8.1)
- ext-mbstring": "*",
- ext-openssl": "*",
- ext-curl": "*",
- ext-json": "*",
- symfony/options-resolver": ">=4.4"

## Installation
> TODO ADD INSTALL DOCS


### Response codes table
>
> |Response Code (RC)|RC DESCRIPTION |    
> |------------------|---------------|   
> |00                | Sucessfull    |
> |                  | => Timeout |
> |"01"              | Refer to card issuer |
> |"04"              | Pick Up |
> |"05"              | Do not Honour |
> |"13"              | Invalid amount |
> |"30"              | Format error |
> |"65"              | Soft Decline |
> |"91"              | Issuer or switch is inoperative |
> |"96"              | System Malfunction |   

> ### Credit cards for testing
> 
>>#### Cards
>>
>>| Тип на карта | Номер на карта (PAN) | Реакция на APGW / Reponse code                                                          | Response Code Описание          | Изисква тестов ACS    |
>>|--------------|----------------------|-----------------------------------------------------------------------------------------|---------------------------------|-----------------------|
>>| Mastecard    | 5100770000000022     | Response code = 00                                                                      | Successfully completed          | Не                    |
>>| Mastecard    | 5555000000070019     | Response code = 04                                                                      | Pick Up                         | Не                    |
>>| Mastecard    | 5555000000070027     | Системата се забавя 30 сек. за авторизация, Response code = 13                          | Invalid amount                  | Не                    |
>>| Mastecard    | 5555000000070035     | Timeout, Response code = 91                                                             | Issuer or switch is inoperative | Не                    |
>>| Visa         | 4341792000000044     | Response code = 00 Това е пълен тест с автентификация от тестов Visa ACS и авторизация. | Successfully Completed          | Да, паролата е 111111 |
>>
>> #### Карти, за които се получава съответен резултат при транзакция според сумата
>> 
>> | Тип на карта | Номер на карта (PAN) | Реакция на APGW / RC                     | Изисква тестов ACS    |   |
>> |--------------|----------------------|------------------------------------------|-----------------------|---|
>> | Visa         | 4010119999999897     | Зависи от сумата. Виж таблицата по-долу. | Не                    |   |
>> | Mastecard    | 5100789999999895     |                                          | Да, паролата е 111111 |   |
>> 
>> | Сума от | Сума до | Реакция на APGW / Reponse code | RC Описание                     | Коментар              |
>> |---------|---------|--------------------------------|---------------------------------|-----------------------|
>> |    1.00 |    1.99 |                             01 | Refer to card issuer            |                       |
>> |    2.00 |    2.99 |                             04 | Pick Up                         |                       |
>> |    3.00 |    3.99 |                             05 | Do not Honour                   |                       |
>> |    4.00 |    4.99 |                             13 | Invalid amount                  | Response after 30 sec |
>> |    5.00 |    5.99 |                             30 | Format error                    |                       |
>> |    6.00 |    6.99 |                             91 | Issuer or switch is inoperative |                       |
>> |    7.00 |    7.99 |                             96 | System Malfunction              |                       |
>> |    8.00 |    8.99 |                                | Timeout                         |                       |
>> |   30.00 |   40.00 |                             01 | Refer to card issuer            |                       |
>> |   50.00 |   70.00 |                             04 | Pick Up                         |                       |
>> |   80.00 |   90.00 |                             05 | Do not Honour                   |                       |
>> |  100.00 |  110.00 |                             13 | Invalid amount                  | Response after 30 sec |
>> |  120.00 |  130.00 |                             30 | Format error                    |                       |
>> |  140.00 |  150.00 |                             91 | Issuer or switch is inoperative |                       |
>> |  160.00 |  170.00 |                             96 | System Malfunction              |                       |
>> |  180.00 |  190.00 |                                | Timeout                         |                       |
