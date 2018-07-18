<?php


namespace core\Models\Tasks;


class Task
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $description;

    /**
     * @var int
     */
    public $estimateHours;

    /**
     * @var int
     */
    public $estimateMinutes;

    /**
     * @var int
     */
    public $spendHours;

    /**
     * @var int
     */
    public $spendMinutes;

    /**
     * Приоритет задачи - в зависимости от требований
     * можно считать число синонимом строкового представления приоритета
     * @var int
     */
    public $priority;

    /**
     * @var int
     */
    public $sprintId;

    /**
     * false - задача закрыта,
     * true - задача открыта
     * @var bool
     */
    public $status;
}