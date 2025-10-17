# Symfony validator for Entity Does Not Exist

A validator that verifies that an Entity actually does not exists.
This is useful if the client of your api provides the ID to create an entity. You do not want an ID collision.


```php
namespace App\Message\Command;

use Dayploy\Validator\Constraint\EntityDoesNotExist;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateUser
{
    #[EntityDoesNotExist(entity: User::class, property: 'id')]
    private Uuid $id;
    // ...
```


## Install

```console
composer require dayploy/entity-does-not-exists-validation-constraint

```

Then register the services with:

```yaml
# config/packages/dayploy_entity_does_not_exists_validator.yaml
services:
  Dayploy\Validator\Constraint\EntityDoesNotExistValidator:
    arguments: ['@doctrine.orm.entity_manager']
    tags: [ 'validator.constraint_validator' ]
```
