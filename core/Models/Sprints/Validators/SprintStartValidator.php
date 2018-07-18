<?php

namespace core\Models\Sprints\Validators;

require 'core\Models\Tasks\TaskRepository.php';
require 'core\Models\Sprints\SprintRepository.php';
require 'vendor\autoload.php';

use core\Models\Sprints\SprintRepository;
use Carbon\Carbon;
use core\Models\Tasks\TaskRepository;
use database\db;

class SprintStartValidator
{
    /**
     * @param int $sprintId
     * @param TaskRepository $taskRepo
     * @throws \InvalidArgumentException
     */
    public function validateHours($sprintId, TaskRepository $taskRepo)
    {
        $tasks = $taskRepo->getBySprintId($sprintId);
        $summOfMinutes = 0;
        $summOfHours = 0;
        foreach ($tasks as $task) {
            if ($task->estimateMinutes === null && $task->estimateHours === null) {
                throw new \InvalidArgumentException('В спринте есть задачи без оценки');
            }
            $summOfMinutes += $task->estimateMinutes;
            $summOfHours += $task->estimateHours;
        }
        $summOfHours += $summOfMinutes / 60;

        if ($summOfHours > 40) {
            throw new \InvalidArgumentException('Невозможно запустить спринт 
            - суммарная оценка времени больше 40 часов');
        }
    }


    /**
     * @param SprintRepository $sprintRepo
     * @throws \BadMethodCallException
     */
    public function validateOtherSprintsStatuses(SprintRepository $sprintRepo)
    {
        if ($sprintRepo->getAllStart()) {
            throw new \BadMethodCallException('Уже есть открытый спринт');
        }
    }

    /**
     * @param int $sprintId
     * @param SprintRepository $sprintRepo
     * @throws \InvalidArgumentException
     */
    public function validateTime($sprintId, SprintRepository $sprintRepo)
    {
        $sprints = $sprintRepo->getById($sprintId);
        foreach ($sprints as $sprint) {
            if (Carbon::now()->year != $sprint->year) {
                throw new \InvalidArgumentException('Невозможно запустить спринт, Вы не в том году :)');
            }

            if (Carbon::now()->weekOfYear != $sprint->weekNumber) {
                throw new \InvalidArgumentException('Невозможно запустить спринт, Вы не в той неделе :)');
            }
        }
    }
}