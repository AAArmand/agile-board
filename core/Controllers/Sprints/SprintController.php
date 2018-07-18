<?php

namespace core\Controllers\Sprints;

require 'core\Models\Sprints\SprintRepository.php';
require 'core\Models\Sprints\Validators\SprintStartValidator.php';
require 'core\Models\Sprints\Validators\SprintStopValidator.php';

use core\Models\Sprints\SprintRepository;
use core\Models\Sprints\Validators\SprintStartValidator;
use core\Models\Sprints\Validators\SprintStopValidator;

class SprintController
{
    /**
     * @var SprintRepository
     */
    private $repo;

    /**
     * @param SprintRepository $repo
     */
    public function __construct($repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param array $requestArray
     * @throws \InvalidArgumentException
     */
    public function addSprint($requestArray)
    {
        if (isset($requestArray['week-number']) && isset($requestArray['year'])) {
            $this->repo->add(['week-number'], $requestArray['year']);
        } else {
            throw new \InvalidArgumentException('У спринта отсутствует номер недели и не передан год');
        }
    }

    /**
     * @param string|int $id
     */
    public function startSprint($id)
    {
        $this->repo->start($id, new SprintStartValidator());
    }

    /**
     * @param string|int $id
     */
    public function stopSprint($id)
    {
        $this->repo->stop($id, new SprintStopValidator());
    }

    /**
     * @return \core\Models\Sprints\Sprint[]
     */
    public function getAllSprints()
    {
        return $this->repo->getAll();
    }
}