<?php

namespace Agendanet\Domain\Doctor\Repository;

use Agendanet\App\Commons\Database\Database;
use Agendanet\Domain\Doctor\Entity\Doctor;
use Agendanet\Domain\Doctor\Entity\DoctorSchedule;
use DateTime;

class DoctorScheduleRepositoryPDO extends Database implements DoctorScheduleRepositoryInterface
{
    public function findSchedule(
        $doctorId, 
        DateTime $dateTime
    ): ?DoctorSchedule {
        $stmt = $this->pdo->prepare(
            'SELECT * 
            FROM doctor_schedule 
            WHERE doctor_id = :doctor_id
                AND datetime = :datetime'
        );
        $stmt->execute([
            'doctor_id' => $doctorId,
            'datetime' => $dateTime->format('Y-m-d H:i:s')
        ]);
        $res = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($res != null) {
            $doctor = new Doctor($res['doctor_id']);
            $dateTime = DateTime::createFromFormat(
                'Y-m-d H:i:s', 
                $res['datetime']
            );
            $available = (bool) $res['available'];
            
            return new DoctorSchedule(
                $doctor, 
                $dateTime, 
                $available
            );
        }
        
        return null;
    }
}
