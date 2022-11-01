<?php

namespace Agendanet\Domain\Schedule\Repository;

use Agendanet\Domain\Schedule\Entity\Schedule;
use Agendanet\App\Commons\Database\Database;
use Exception;

class ScheduleRepositoryPDO extends Database implements ScheduleRepositoryInterface
{
    public function create(Schedule $schedule): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO schedule 
                (id, pacient_name, pacient_phone, doctor_id, 
                datetime, status, created_at, updated_at)
            VALUES
                (:id, :pacient_name, :pacient_phone, :doctor_id, 
                :datetime, :status, :created_at, :updated_at)'
        );
        
        $executed = $stmt->execute([
            'id' => $schedule->id,
            'pacient_name' => $schedule->pacient->name,
            'pacient_phone' => $schedule->pacient->phone,
            'doctor_id' => $schedule->doctor->id,
            'datetime' => $schedule->dateTime->format('Y-m-d H:i:s'),
            'status' => $schedule->status->value,
            'created_at' => $schedule->createdAt->format('Y-m-d H:i:s'),
            'updated_at' => null
        ]);
        
        if (!$executed) {
            throw new Exception(
                'Fail to create the schedule: ' 
                . $stmt->errorInfo()[0]
            );
        }
    }
}
