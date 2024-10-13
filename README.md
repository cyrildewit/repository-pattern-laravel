**Edit:** For everyone who is considering to apply the repository pattern in Laravel. I have stepped away from it, since Eloquent ORM already kind of acts as a repository.

# Repository Pattern in Laravel 5.* example

In this git repository you'll find some code examples of my implementation of the repository pattern in Laravel

The place where you should create a repository is inside the `App\Repositories` folder.

Every repository should be registerd inside a Service Provider. To keep it simple, I placed this inside the AppServiceProvider.php file.

## Future

I'm considering about creating a package to simplify the use of my way of implementing the repository pattern.
This package will only contain some abstract base classes.

# Using a Repository in your Controllers

```php
// App/Controllers/CoursesController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Course\CourseRepositoryInterface;

class CoursesController extends Controller
{
    /** @var \App\Repositories\Course\CourseRepositoryInterface */
    protected $courseRepository;

    /**
     * Constructor function of CoursesController
     *
     * @return void
     */
    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }
    
    /**
     * Returns the courses catalog page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $courses = $this->coursesRepository->getAll();
        
        return view('courses.index', [
            'courses' => $courses,
        ]);
    }
}
```
