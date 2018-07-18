<?php

namespace core\Controllers\Tasks;

require 'core\Models\Tasks\TaskRepository.php';

use core\Models\Tasks\TaskRepository;

class TaskController
{
    /**
     * @var TaskRepository
     */
    private $repo;

    /**
     * @param $repo TaskRepository
     */
    public function __construct($repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param array $requestArray
     * @throws \InvalidArgumentException
     */
    public function addTask($requestArray)
    {
        if (isset($requestArray['title']) && isset($requestArray['description'])) {
            $this->repo->add($requestArray['title'], $requestArray['description']);
        } else {
            throw new \InvalidArgumentException('У задачи отсутствует заголовок и описание');
        }
    }

    /**
     * @param array $requestArray
     * @throws \InvalidArgumentException
     */
    public function estimateTask($requestArray)
    {
        if(!isset($requestArray['id'])) {
            throw new \InvalidArgumentException('Задача не привязана');
        }

        if (isset($requestArray['hours']) && isset($requestArray['minutes'])) {
            $this->repo->estimate($requestArray['id'], $requestArray['hours'], $requestArray['minutes']);
        } elseif (isset($requestArray['hours'])) {
            $this->repo->estimate($requestArray['id'], $requestArray['hours']);
        } elseif (isset($requestArray['minutes'])){
            $this->repo->estimate($requestArray['id'], null, $requestArray['minutes']);
        } else {
            throw new \InvalidArgumentException('Время не передано');
        }
    }

    /**
     * @param string|int $taskId
     * @param string|int $sprintId
     */
    public function addTaskToSprint($taskId, $sprintId)
    {
        $this->repo->addToSprint($taskId, $sprintId);
    }

    /**
     * @param string|int $id
     */
    public function closeTask($id)
    {
        $this->repo->close($id);
    }

    /**
     * @return \core\Models\Tasks\Task[]
     */
    public function getTasksForBacklog()
    {
        return $this->repo->getAll();
    }

    /**
     * @param $sprintId
     * @return \core\Models\Tasks\Task[]
     */
    public function getTasksForSprint($sprintId)
    {
        return $this->repo->getBySprintId($sprintId);
    }
}