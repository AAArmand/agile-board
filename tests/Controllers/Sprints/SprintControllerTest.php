<?php
namespace tests\Controllers\Sprints;

require 'core\Controllers\Sprints\SprintController.php';
require 'core\Models\Sprints\SprintRepository.php';
require 'vendor\autoload.php';

use core\Controllers\Sprints\SprintController;
use core\Models\Sprints\SprintRepository;

use PHPUnit\Framework\TestCase;

class SprintControllerTest extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddSprint_hasWrongInputArray_throwsException()
    {
        $mock = $this->prophesize(SprintRepository::class);
        $mock->add()->willReturn(true);
        $mock->add()->shouldNotBeCalled();

        (new SprintController($mock->reveal()))->addSprint(['a', 'b']);
    }

    public function testAddSprint_hasCorrectInputArray()
    {
        $mock = $this->prophesize(SprintRepository::class);
        $mock->add()->willReturn(true);
        $mock->add()->shouldBeCalled();

        (new SprintController($mock->reveal()))->addSprint(['week-number' => 29, 'year' => 2018]);
    }

    public function testStartSprint()
    {
        $mock = $this->prophesize(SprintRepository::class);
        $mock->start()->willReturn(true);
        $mock->start()->shouldBeCalled();

        (new SprintController($mock->reveal()))->startSprint(1);
    }

    public function testStopSprint()
    {
        $mock = $this->prophesize(SprintRepository::class);
        $mock->stop()->willReturn(true);
        $mock->stop()->shouldBeCalled();

        (new SprintController($mock->reveal()))->stopSprint(1);
    }

    public function getAllSprints()
    {
        $mock = $this->prophesize(SprintRepository::class);
        $mock->getAll()->willReturn(true);
        $mock->getAll()->shouldBeCalled();

        (new SprintController($mock->reveal()))->getAllSprints();
    }
}