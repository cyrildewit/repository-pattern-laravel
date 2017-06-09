# Repository Pattern in Laravel 5.* example

In this git repository you'll find some code examples of my implementation of the repository pattern in Laravel

The place where you should create a repository is inside the `App\Repositories` folder.

Every repository should be registerd inside a Service Provider. To keep it simple, I placed this inside the AppServiceProvider.php file.

## Future

I'm considering about creating a package to simplify the use of my way of implementing the repository pattern.
This package will only contain some abstract base classes.

# Using a Repository in your Controllers

```php
// ...
class CoursesController extends Model
{
    /**
     * Constructor function of CoursesController
     *
     * @return void
     */
    public function __construct
}
```
