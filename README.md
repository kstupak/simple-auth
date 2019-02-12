## Simple Symfony auth

### Installation
___

1. Run 
```bash
composer require kstupak/simple-auth:dev-master
```

2. Add following snippet to ```config/packages/doctrine.yaml```:
```yaml
doctrine:
  orm:
    mappings:
      SimpleAuth\:
        is_bundle: false
        type: xml
        dir: '%kernel.project_dir%/vendor/kstupak/simple-auth/src/Resource/mappings'
        prefix: 'SimpleAuth'
        alias: SimpleAuth
``` 

3. Add definition for ```uuid_binary``` type for doctrine:
```yaml
# config/packages/ramsey_uuid_doctrine.yaml

doctrine:
  dbal:
    types:
      uuid_binary: 'Ramsey\Uuid\Doctrine\UuidBinaryType'
```

4. Add service definitions to ```config/services.yaml``` at the very top of the file:
```yaml
imports:
  - { resource:  "../vendor/kstupak/simple-auth/src/Resource/simple_auth.yaml" }
```

5. Create an implementation of ```SimpleAuth\UserProvider``` in your project and set container to use it:
```yaml
# config/services.yaml

parameters:
  security.user_provider: App\Service\User\UserProvider #replace with your implementation class name
```

6. Copy contents of the ```vendor/kstupak/simple-auth/src/Resource/security.yaml``` to ```config/packages/security.yaml```
7. Add routing config to ```config/routes.yaml```
```yaml
security:
  resource: '../vendor/kstupak/simple-auth/src/Controller/SecurityController.php'
  type: annotation
```


___
### Usage

1. Make your User implementation extend ```SimpleAuth\Model\User```:
```php
<?php

namespace App\Entity;

use App\Model\UserRoles;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use SimpleAuth\Model\User as BaseUser;

class User extends BaseUser
{
    /** @var UuidInterface */
    private $id;

    /** @var array */
    private $roles;

    public function __construct(
        string $name,
        string $email,
        string $password
    ){
        parent::__construct($name, $email, $password);
        $this->roles = [UserRoles::USER];
        $this->id = Uuid::uuid4();
    }
}
```

2. Create your implementation for ```SimpleAuth\UserProvider```:
```php
<?php

namespace App\Service\User;

use App\Entity\User;

final class UserProvider extends \SimpleAuth\UserProvider
{
    public function supportsClass($class)
    {
        return $class = User::class;
    }
}
```