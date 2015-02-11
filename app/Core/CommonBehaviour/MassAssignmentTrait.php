<?php


namespace Mabes\Core\CommonBehaviour;

/**
 * Class MassAssignmentTrait
 * @package Mabes\Core\CommonBehaviour
 */
trait MassAssignmentTrait
{
    /**
     * @param array $data
     */
    public function massAssignment(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}

// EOF
