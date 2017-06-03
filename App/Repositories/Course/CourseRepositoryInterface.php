<?php

namespace App\Repositories\Course;

interface CourseRepositoryInterface
{
    /**
     * Get one by slug collumn.
     * @param string $slug
     * @return mixed
     */
    public function findBySlug(string $slug);

    /**
     * Get all most popular courses.
     * @return mixed
     */
    public function getMostPopularCourses();

    /**
     * Get all recent created courses.
     * @return mixed
     */
    public function getRecentCreatedCourses();

    /**
     * Get all posts only published
     * @return mixed
     */
    public function getAllPublished();

    /**
     * Get post only published
     * @return mixed
     */
    public function findOnlyPublished($id);
}
