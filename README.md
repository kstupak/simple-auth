## Simple Symfony auth

### Installation
___

1. Run 
```bash
composer require kstupak/simple-auth:dev-master
```

2. Make your User implementation extend ```SimpleAuth\Model\User```:
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
        $this->id    = Uuid::uuid4();
    }
}
```

3. Create your implementation for ```SimpleAuth\UserProvider```:
```php
<?php

namespace App\Service\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class UserProvider extends \SimpleAuth\UserProvider
{
    /** @var EntityRepository */
    protected $repository;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(User::class);
    }
    
    public function supportsClass($class)
    {
        return $class = User::class;
    }
}
```

2. Add following snippet to ```config/packages/doctrine.yaml```:
```yaml
doctrine:
  orm:
    mappings:
      SimpleAuth\:
        is_bundle: false
        type: xml
        dir: '%kernel.project_dir%/vendor/kstupak/simple-auth/src/Resources/mappings'
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

4. Copy contents of the ```vendor/kstupak/simple-auth/src/Resource/security.yaml``` to ```config/packages/security.yaml``` and replace ```providers.user.id``` value with class name of your own user provider implementation

5. Register bundle:
```php
<?php

# config/bindles.php

return [
    # Here are other bundles
    \SimpleAuth\SimpleAuthBundle::class => ['all' => true],
];

```

5. Add routing config to ```config/routes.yaml```
```yaml
security:
  resource: '../vendor/kstupak/simple-auth/Controller/SecurityController.php'
  type: annotation
```