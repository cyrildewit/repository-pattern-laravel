<?php

namespace App\Repositories\Course;

use App\Repositories\EloquentRepository;

class CourseEloquentRepository extends EloquentRepository implements CourseRepositoryInterface
{
    /**
     * Get model.
     *
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Course\Course::class;
    }

    /**
     * Find the course with the given slug.
     *
     * @param $id
     * @return mixed
     */
    public function findBySlug(string $slug) {
        return $this->getFirstBy('slug', $slug);
    }

    /**
     * Get the most popular courses.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getMostPopularCourses()
    {
        $result = $this
            ->_model
            ->orderBy('view_counter', 'desc')
            ->get();

        return $result;
    }

    /**
     * Get most popular courses.
     *
     * @param string $subject
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getMostPopularCoursesBySubject(string $subject)
    {
        $result = $this
            ->_model
            ->whereHas('subjects', function ($query) use ($subject) {
                $query->where('slug', $subject);
            })
            ->orderBy('view_counter', 'desc')
            ->get();

        return $result;
    }

    /**
     * Get recent created courses.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getRecentCreatedCourses()
    {
        $result = $this
            ->_model
            ->orderBy('created_at', 'desc')
            ->get();

        return $result;
    }

    /**
     * Get recent created courses.
     * @param string $subject
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getRecentCreatedCoursesBySubject(string $subject)
    {
        $result = $this
            ->_model
            ->whereHas('subjects', function ($query) use ($subject) {
                $query->where('slug', $subject);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return $result;
    }

    /**
     * Get recent created courses.
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllPublished()
    {
        $result = $this->getManyBy('status', 'publish');

        return $result;
    }

    /**
     * Get recent created courses.
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findOnlyPublished($id)
    {
        $result = $this
            ->_model
            ->where('id', $id)
            ->where('status', 'publish')
            ->first();

        return $result;
    }

    /**
     * Count the number of coures by subject.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function countCoursesBySubject(string $subject)
    {
        $result = $this
            ->_model
            ->whereHas('subjects', function ($query) use ($subject) {
                $query->where('slug', $subject);
            })
            ->count();

        return $result;
    }
}
