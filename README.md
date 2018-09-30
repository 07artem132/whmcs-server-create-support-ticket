# whmcs-server-create-support-ticket
Файлы разместить в папке \whmcs-root\modules\servers\CreateSupportTicket <br/>
whmcs-root - корень whmcs

Основная цель данного модуля это замена мало функционального модуля от whmcs https://docs.whmcs.com/Auto_Release <br/>

Данный модуль провижинга позволяет настраивать: <br/>
Создавать ли тикет при:
* Создание услуги
* Приостановка услуги
* Возобновление услуги
* Удаление услуги
* Продление услуги

Для каждого события настраиваются такие параметры как: 

* Тема тикета
* Сообщение в тикете
* Приоритет тикета

Так же при создании тикета в сообщении и заголовке могут использоваться значения дополнительных полей продукта и глобальные значения к примеру %имя дополнительного поля% будет преобразовано в значения дополнительного поля <br/>
Доступные глобальные макро-значения:<br/>
* %serviceid% - идентификатор услуги
* %userid% - ид клиента
* %producttype% - тип продукта
* %clientFirstName% - имя клиента
* %clientLastName% - фамилия клиента
* %clientFullName% - полное имя клиента
* %clientCompanyName% - название компании клиента
* %clientEmail%  - email адрес клиента