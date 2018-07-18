<?php


namespace core\Models\Sprints;

require 'core\Models\Tasks\TaskRepository.php';
require 'core\Models\Sprints\Sprint.php';

use core\Models\Sprints\Validators\SprintStartValidator;
use core\Models\Sprints\Validators\SprintStopValidator;
use core\Models\Tasks\TaskRepository;
use database\db;

class SprintRepository
{
    /**
     * @param string|int $week
     * @param string|int $year
     */
    public function add($week, $year)
    {
        $week = (int) $week;
        $year = (int) $year;
        db::query( "INSERT INTO `sprints` SET week_number = {$week}, year = {$year}");
    }

    /**
     * @param string|int $id
     * @param SprintStartValidator $validator
     * @throws \InvalidArgumentException
     * @throws \BadMethodCallException
     */
    public function start($id, $validator)
    {
        $id = (int) $id;

        $validator->validateHours($id, new TaskRepository());
        $validator->validateOtherSprintsStatuses($this);
        $validator->validateTime($id, $this);

        db::query("UPDATE `sprints` SET `status` = 1 WHERE id = {$id}");

    }


    /**
     * @param string|int $id
     * @param SprintStopValidator $validator
     * @throws \InvalidArgumentException
     */
    public function stop($id, $validator)
    {
        $id = (int) $id;
        $validator->validateTasksStatus($id, new TaskRepository());

        db::query("UPDATE `sprints` SET `status` = 0 WHERE id = {$id}");
    }

    /**
     * @return Sprint[]
     */
    public function getAll()
    {
        $res = db::query('SELECT `id`, 
                                        `status`, 
                                        `week_number`, 
                                        `year`
                                        FROM `sprints`
                                        WHERE del = 0');
        return $this->formSprint($res);
    }

    public function getById($sprintId)
    {
        $id = (int)$sprintId;
        $res = db::query("SELECT `id`, 
                                        `status`, 
                                        `week_number`, 
                                        `year`
                                        FROM `sprints`
                                        WHERE `del` = 0 AND `id` = {$id}");
        return $this->formSprint($res);
    }

    /**
     * @return Sprint[]
     */
    public function getAllStart()
    {
        $res = db::query('SELECT `id`, 
                                        `status`, 
                                        `week_number`, 
                                        `year`
                                        FROM `sprints`
                                        WHERE `del` = 0 AND `status` = 1');

        return $this->formSprint($res);
    }

    /**
     * @param \mysqli_result $res
     * @return Sprint[]
     */
    private function formSprint($res)
    {
        $sprints = [];
        while ($row = db::fetch_assoc($res)) {
            $sprint = new Sprint();
            $sprint->id = (int) $row['id'];
            $sprint->status = $row['status'];
            $sprint->weekNumber = $row['week_number'];
            $sprint->year = $row['year'];
            $sprints[] = $sprint;
        }

        return $sprints;
    }

}