<?php
namespace tests\Models\Sprints\Validators;
require 'vendor\autoload.php';
require 'core\Models\Tasks\TaskRepository.php';
require 'core\Models\Sprints\SprintRepository.php';
require 'core\Models\Tasks\Task.php';
require 'core\Models\Sprints\Validators\SprintStartValidator.php';
require 'core\Models\Sprints\Sprint.php';

use Carbon\Carbon;
use core\Models\Sprints\Sprint;
use core\Models\Sprints\SprintRepository;
use core\Models\Sprints\Validators\SprintStartValidator;
use core\Models\Tasks\Task;
use core\Models\Tasks\TaskRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class SprintStartValidatorTest extends TestCase
{

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testValidateHours_hasNoEstimateTaskInSprint_throwsException()
    {
        $task = new Task();
        $task->estimateHours = null;
        $task->estimateMinutes = null;

        $mock = $this->prophesize(TaskRepository::class);
        $mock->getBySprintId(Argument::is(1))->willReturn([$task]);
        (new SprintStartValidator())->validateHours(1, $mock->reveal());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testValidateHours_hasMoreThan40HoursEstimate_throwsException()
    {
        $task1 = new Task();
        $task1->estimateHours = 40;
        $task1->estimateMinutes = 30;

        $task2 = new Task();
        $task2->estimateHours = 40;
        $task2->estimateMinutes = 30;

        $mock = $this->prophesize(TaskRepository::class);
        $mock->getBySprintId(Argument::is(1))->willReturn([$task1, $task2]);

        (new SprintStartValidator())->validateHours(1, $mock->reveal());
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testValidateOtherSprintsStatuses_hasStartSprint_throwsException()
    {
        $mock = $this->prophesize(SprintRepository::class);
        $mock->getAllStart()->willReturn(true);

        (new SprintStartValidator())->validateOtherSprintsStatuses($mock->reveal());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testValidateTime_hasIncorrectYear_throwsException()
    {
        $sprint = new Sprint();
        $sprint->year = Carbon::now()->year - 1;
        $sprint->weekNumber = Carbon::now()->weekOfYear;

        $mock = $this->prophesize(SprintRepository::class);
        $mock->getById(Argument::is(1))->willReturn([$sprint]);
        (new SprintStartValidator())->validateHours(1, $mock->reveal());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testValidateTime_hasIncorrectWeek_throwsException()
    {
        $sprint = new Sprint();
        $sprint->year = Carbon::now()->year;
        $sprint->weekNumber = Carbon::now()->weekOfYear - 2;

        $mock = $this->prophesize(SprintRepository::class);
        $mock->getById(Argument::is(1))->willReturn([$sprint]);
        (new SprintStartValidator())->validateHours(1, $mock->reveal());
    }
}