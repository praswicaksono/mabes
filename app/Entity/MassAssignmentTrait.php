<?php


namespace Mabes\Entity;


trait MassAssignmentTrait
{
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
