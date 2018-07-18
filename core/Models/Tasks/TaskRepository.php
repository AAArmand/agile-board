<?php

namespace core\Models\Tasks;


use database\db;

class TaskRepository
{
    /**
     * @param string $title
     * @param string $description
     */
    public function add($title, $description)
    {
        $title = db::escape_string($title);
        $description = db::escape_string($description);
        db::query( "INSERT INTO `tasks` SET description = '{$description}', title = '{$title}'");
    }

    /**
     * @param int $id
     * @param string $hours
     * @param string $minutes
     */
    public function estimate($id, $hours = null, $minutes = null)
    {
        $id = (int)$id;
        $hours = $hours ? (int)explode('h', $hours)[0] : null;
        $minutes = $minutes ? (int)explode('m', $minutes)[0] : null;
        db::query("UPDATE `tasks` SET estimate_hours = {$hours}, estimate_minutes = {$minutes} 
                            WHERE id={$id}");
    }

    /**
     * @param int $taskId
     * @param int $sprintId
     */
    public function addToSprint($taskId ,$sprintId)
    {
        $taskId = (int) $taskId;
        $sprintId = (int) $sprintId;
        db::query("UPDATE `tasks` SET sprint_id = {$sprintId} WHERE id = {$taskId}");
    }

    /**
     * @param int $id
     */
    public function close($id)
    {
        $id = (int) $id;
        db::query("UPDATE `tasks` SET status = 0 WHERE id = {$id}");
    }

    /**
     * @return Task[]
     */
    public function getAll()
    {
        $res = db::query('SELECT `id`, 
                                        `title`, 
                                        `description`, 
                                        `estimate_hours`,
                                        `estimate_minutes`,
                                        `spend_hours`,
                                        `spend_minutes`,
                                        `sprint_id`,
                                        `status`,
                                        `priority` 
                                        FROM  `tasks`
                                        WHERE `del` = 0
                                        ORDER BY `priority`');

        return $this->formTasks($res);
    }

    /**
     * @param int $sprintId
     * @return Task[]
     */
    public function getBySprintId($sprintId)
    {
        $sprintId = (int) $sprintId;
        $res = db::query("
                                 SELECT `id`, 
                                        `title`, 
                                        `description`, 
                                        `estimate_hours`,
                                        `estimate_minutes`,
                                        `spend_hours`,
                                        `spend_minutes`,
                                        `sprint_id`,
                                        `status`,
                                        `priority` 
                                 FROM `tasks`
                                 WHERE `del` = 0 AND `sprint_id` = {$sprintId}
                                 ORDER BY `priority`"
        );

        return $this->formTasks($res);
    }

    /**
     * @param \mysqli_result $res
     * @return Task[]
     */
    private function formTasks($res)
    {
        $tasks = [];
        while ($row = db::fetch_assoc($res)) {
            $task = new Task();
            $task->id = (int) $row['id'];
            $task->title = $row['title'];
            $task->description = $row['description'];
            $task->estimateHours = (int)$row['estimate_hours'];
            $task->estimateMinutes = (int)$row['estimate_minutes'];
            $task->spendHours = (int)$row['spend_hours'];
            $task->spendMinutes =(int) $row['spend_minutes'];
            $task->sprintId = (int)$row['sprint_id'];
            $task->status = (bool)$row['status'];
            $task->priority = (int) $row['priority'];
            $tasks[] = $task;
        }

        return $tasks;
    }

}