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