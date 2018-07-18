<?php


namespace tests\Models\Sprints\Validators;

require 'vendor\autoload.php';
require 'core\Models\Sprints\SprintRepository.php';
require 'core\Models\Tasks\Task.php';
require 'core\Models\Sprints\Validators\SprintStopValidator';

use core\Models\Sprints\SprintRepository;
use core\Models\Sprints\Validators\SprintStopValidator;
use core\Models\Tasks\Task;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class SprintStopValidatorTest extends TestCase
{
    /**
     * @expectedException \BadMethodCallException
     */
    public function testValidateOtherSprintsStatuses_hasStartSprint_throwsException()
    {
        $task = new Task();
        $task->status = true;

        $mock = $this->prophesize(SprintRepository::class);
        $mock->getBySprintId(Argument::is(1))->willReturn([$task]);

        (new SprintStopValidator())->validateTasksStatus(1, $mock->reveal());
    }
}