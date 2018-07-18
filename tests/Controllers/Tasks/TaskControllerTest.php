<?php
namespace tests\Controllers\Tasks;
require 'core\Models\Tasks\TaskRepository';
require 'core\Controllers\Tasks\TaskController';
require 'vendor\autoload.php';

use core\Controllers\Tasks\TaskController;
use core\Models\Tasks\TaskRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class TaskControllerTest extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddTask_hasWrongInputArray_throwsException()
    {
        $mock = $this->prophesize(TaskRepository::class);
        $mock->add()->shouldNotBeCalled();

        (new TaskController($mock->reveal()))->addTask(['a', 'b']);
    }

    public function testAddTask_hasCorrectInputArray()
    {
        $mock = $this->prophesize(TaskRepository::class);
        $mock->add()->shouldBeCalled();

        (new TaskController($mock->reveal()))->addTask(['title' => 'Новая задача', 'description' => 'тестовое описание']);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testEstimateTask_hasNotIdInInputArray_throwsException()
    {
        $mock = $this->prophesize(TaskRepository::class);

        (new TaskController($mock->reveal()))->estimateTask(['a', 'b', 'c']);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testEstimateTask_hasNoHoursAndMinutesInInputArray_throwsException()
    {
        $mock = $this->prophesize(TaskRepository::class);

        (new TaskController($mock->reveal()))->estimateTask(['id' => 1, 'a', 'b']);
    }

    public function testEstimateTask_hasFullDataInInputArray()
    {
        $mock = $this->prophesize(TaskRepository::class);
        $mock->estimate(Argument::is(1), Argument::is('2h'), Argument::is('30m'))->shouldBeCalled();

        (new TaskController($mock->reveal()))->estimateTask(['id' => 1, 'hours' => '2h', 'minutes' => '30m']);
    }

    public function testEstimateTask_hasOnlyHoursInInputArray()
    {
        $mock = $this->prophesize(TaskRepository::class);
        $mock->estimate(Argument::is(1), Argument::is('2h'))->shouldBeCalled();

        (new TaskController($mock->reveal()))->estimateTask(['id' => 1, 'hours' => '2h']);
    }

    public function testEstimateTask_hasOnlyMinutesInInputArray()
    {
        $mock = $this->prophesize(TaskRepository::class);
        $mock->estimate(Argument::is(1), Argument::is(null), Argument::is('20m'))->shouldBeCalled();

        (new TaskController($mock->reveal()))->estimateTask(['id' => 1, 'minutes' => '20m']);
    }

    public function testAddTaskToSprint()
    {
        $mock = $this->prophesize(TaskRepository::class);
        $mock->addToSprint(Argument::is(1), Argument::is(2))->shouldBeCalled();

        (new TaskController($mock->reveal()))->addTaskToSprint(1, 2);
    }

    public function testCloseTask()
    {
        $mock = $this->prophesize(TaskRepository::class);
        $mock->close(Argument::is(1))->shouldBeCalled();

        (new TaskController($mock->reveal()))->closeTask(1);
    }

    public function testGetTasksForBacklog()
    {
        $mock = $this->prophesize(TaskRepository::class);
        $mock->getAll()->shouldBeCalled();

        (new TaskController($mock->reveal()))->getTasksForBacklog();
    }

    public function testGetTasksForSprint()
    {
        $mock = $this->prophesize(TaskRepository::class);
        $mock->getBySprintId(Argument::is(1))->shouldBeCalled();

        (new TaskController($mock->reveal()))->getTasksForSprint(1);
    }

}