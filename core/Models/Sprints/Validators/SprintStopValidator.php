<?php

namespace core\Models\Sprints\Validators;
require 'core\Models\Tasks\TaskRepository.php';

use core\Models\Tasks\TaskRepository;

class SprintStopValidator
{
    /**
     * @param int $sprintId
     * @param TaskRepository $taskRepo
     */
    public function validateTasksStatus($sprintId, TaskRepository $taskRepo)
    {
        $tasks = $taskRepo->getBySprintId($sprintId);
        foreach ($tasks as $task) {
            if ($task->status) {
                throw new \InvalidArgumentException('В спринте есть незакрытые задачи');
            }
        }
    }
}