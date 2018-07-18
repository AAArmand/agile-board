<?php


namespace core\Models\Sprints;


class Sprint
{
    /**
     * @var int
     */
    public $id;

    /**
     * 0 - спринт закрыт/еще не открыт, 1 - спринт открыт
     * @var bool
     */
    public $status;

    /**
     * @var int
     */
    public $weekNumber;

    /**
     * @var int
     */
    public $year;
}