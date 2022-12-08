# PHP Ticket

## Prerequisites
* PHP 8
* MySQL
* Composer

## Setup
1. Run ``composer update``
2. Execute SQL script at ``db/create_tables.sql`` file.

## Running
1. CLI ``php app``
2. REST ``php -S localhost:8000 -t public``

## Usage
1. Generate Ticket
```bash
php app generate-ticket {event_id} {n}
```

2. Check Ticket
```bash
curl --location --request POST 'http://localhost:8000/ticket/check' \
--form 'event_id="1"' \
--form 'code="DTKVKJ0KNY"'
```

3. Update Ticket
```bash
curl --location --request POST 'http://localhost:8000/ticket/update' \
--form 'event_id="1"' \
--form 'code="DTKVKJ0KNY"' \
--form 'status="claimed"'
```

Or, import Postman collection at ``postman/PHP Ticket.postman_collection.json`` file.