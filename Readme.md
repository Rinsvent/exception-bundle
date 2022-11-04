Exception bundle
===

- Бандл интегрирует в симфони библиотеку https://packagist.org/packages/rinsvent/exception
- Концепция использования исключений описана в пакете по ссылке

Дополнения в текущем бандле
- Система перехватывает исключение. Сериализует его и отдает ошибку в json формате
- Автоматически переводит ошибку под текущую locale

Для production
```json
{
  "codeText": "access_denied",
  "code": 300,
  "message": "Доступ запрещен",
  "summary": "Access denied"
}
```

Для dev
```json
{
  "codeText": "access_denied",
  "code": 300,
  "message": "Доступ запрещен",
  "summary": "Access denied",
  "system_message": "Native exception message",
  "trace": "..."
}
```

Зарегистрировать свой Enum со списком исключений можно например так
```php
<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\ExceptionEnum;
use Rinsvent\Exception\AbstractException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: 'kernel.request', priority: 1000, method: 'onStart')]
class StartConfigListener
{
    public function onStart(): void
    {
        AbstractException::$exceptionEnum = ExceptionEnum::class;
    }
}
```