<?php

namespace Agendanet\Domain\Schedule\UseCase;

use Agendanet\App\Commons\Http\Exceptions\UnprocessableEntityException;
use Agendanet\Domain\Doctor\Repository\Contract\DoctorRepositoryInterface;
use Agendanet\Domain\Schedule\DTO\CreateScheduleRequest;
use Agendanet\Domain\Schedule\DTO\CreateScheduleResponse;

class CreateScheduleUC
{
    private DoctorRepositoryInterface $doctorRepository;
    
    public function __construct(
        DoctorRepositoryInterface $doctorRepository
    ) {
        $this->doctorRepository = $doctorRepository;
    }
    
    public function execute(CreateScheduleRequest $request)
    {
        $this->validateDoctorExists($request->doctorId);
        
        return new CreateScheduleResponse(
            $request->userPhone, 
            $request->userName, 
            $request->doctorId, 
            $request->scheduleDatetime,
            date('Y-m-d H:i:s')
        );
    }
    
    private function validateDoctorExists(string $doctorId): void
    {
        if ($this->doctorRepository->findByDoctorId($doctorId) == null) {
            throw new UnprocessableEntityException(
                "Doctor not found by id:{$doctorId}"
            );
        }
    }
}
