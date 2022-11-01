<?php

namespace Agendanet\Domain\Doctor\Repository;

use Agendanet\App\Commons\Database\Database;
use Agendanet\Domain\Doctor\Entity\Doctor;
use Agendanet\Domain\Doctor\Repository\Contract\DoctorRepositoryInterface;

class DoctorRepositoryPDO extends Database implements DoctorRepositoryInterface
{    
    public function findByDoctorId(string $doctorId): ?Doctor
    {
        $stmt = $this->pdo->prepare('SELECT * FROM doctor WHERE id = :id');
        $stmt->execute(['id' => $doctorId]);
        $res = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($res != null) {
            $doctor = new Doctor($res['id']);
            return $doctor;
        }
        
        return null;
    }
}
