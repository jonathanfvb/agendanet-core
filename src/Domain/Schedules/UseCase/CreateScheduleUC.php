<?php

namespace Agendanet\Domain\Schedules\UseCase;

use Agendanet\Domain\Schedules\DTO\CreateScheduleRequest;
use Agendanet\Domain\Schedules\DTO\CreateScheduleResponse;

class CreateScheduleUC
{
    public function execute(CreateScheduleRequest $request)
    {
        return new CreateScheduleResponse(
            $request->userPhone, 
            $request->userName, 
            $request->doctorId, 
            $request->scheduleDatetime,
            date('Y-m-d H:i:s')
        );
    }
}
