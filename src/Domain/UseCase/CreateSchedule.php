<?php

namespace Agendanet\Domain\UseCase;

use Agendanet\Domain\DTO\CreateScheduleRequest;

class CreateSchedule
{
    public function execute(CreateScheduleRequest $request)
    {
        $data = [
            'user_phone' => $request->userPhone,
            'user_name' => $request->userName,
            'doctor_id' => $request->doctorId,
            'schedule_datetime' => $request->scheduleDatetime,
            'database' => [
                'name' => $_ENV['DB_NAME'] ?? null
            ]
        ];
        
        $out = fopen('php://stdout', 'w');
        fputs($out, "GET Method\n");
        fclose($out);
        
        return $data;
    }
}
