<?php

namespace Agendanet\Domain\Schedule\UseCase;

use Agendanet\App\Commons\Http\Exceptions\BadRequestException;
use Agendanet\App\Commons\Http\Exceptions\UnprocessableEntityException;
use Agendanet\Domain\Doctor\Entity\Doctor;
use Agendanet\Domain\Doctor\Entity\DoctorSchedule;
use Agendanet\Domain\Doctor\Repository\DoctorRepositoryInterface;
use Agendanet\Domain\Doctor\Repository\DoctorScheduleRepositoryInterface;
use Agendanet\Domain\Pacient\Entity\Pacient;
use Agendanet\Domain\Schedule\DTO\CreateScheduleRequest;
use Agendanet\Domain\Schedule\DTO\CreateScheduleResponse;
use Agendanet\Domain\Schedule\Entity\Schedule;
use Agendanet\Domain\Schedule\Factory\ScheduleFactoryInterface;
use Agendanet\Domain\Schedule\Repository\ScheduleRepositoryInterface;
use DateTime;

class CreateScheduleUC
{
    CONST SCHEDULE_DATETIME_FORMAT = 'Y-m-d H:i';
    
    private CreateScheduleRequest $request;
    
    private DoctorRepositoryInterface $doctorRepository;
    
    private DoctorScheduleRepositoryInterface $doctorScheduleRepository;
    
    private ScheduleRepositoryInterface $scheduleRepository;
    
    private ScheduleFactoryInterface $scheduleFactory;
    
    private DateTime $scheduleDateTime;
    
    private Pacient $pacient;
    
    private Doctor $doctor;
    
    private DoctorSchedule $doctorSchedule;
    
    
    public function __construct(
        DoctorRepositoryInterface $doctorRepository,
        DoctorScheduleRepositoryInterface $doctorScheduleRepository,
        ScheduleRepositoryInterface $scheduleRepository,
        ScheduleFactoryInterface $scheduleFactory
    ) {
        $this->doctorRepository = $doctorRepository;
        $this->doctorScheduleRepository = $doctorScheduleRepository;
        $this->scheduleRepository = $scheduleRepository;
        $this->scheduleFactory = $scheduleFactory;
    }
    
    public function execute(
        CreateScheduleRequest $request
    ): CreateScheduleResponse {
        $this->request = $request;
        $this->setScheduleDateTime();
        $this->setPacient();
        $this->setDoctor();
        $this->setDoctorScheduleByDateTime();
        $this->validateDoctorSchedule();
        $schedule = $this->makeSchedule();
        $this->registerSchedule($schedule);
        return $this->makeResponse($schedule);
    }
    
    private function setScheduleDateTime(): void
    {
        $dateTime = DateTime::createFromFormat(
            self::SCHEDULE_DATETIME_FORMAT,
            $this->request->scheduleDatetime
        );
        if ($dateTime == null) {
            throw new BadRequestException(
                "Schedule datetime is not in the expected format "
                . "'".self::SCHEDULE_DATETIME_FORMAT."'"
            );
        }
        
        $this->scheduleDateTime = $dateTime;
    }
    
    private function setPacient(): void
    {
        $this->pacient = new Pacient(
            $this->request->userName,
            $this->request->userPhone
        );
    }
    
    private function setDoctor(): void
    {
        $doctor = $this->doctorRepository->findByDoctorId(
            $this->request->doctorId
        );
        if ($doctor == null) {
            throw new UnprocessableEntityException(
                "Doctor not found by id:{$this->request->doctorId}"
            );
        }
        
        $this->doctor = $doctor;
    }
    
    private function getDoctorScheduleByDateTime(): void
    {
        $doctorSchedule = $this->doctorScheduleRepository
            ->findSchedule(
                $this->doctor->id, 
                $this->scheduleDateTime
            );
        if ($doctorSchedule == null) {
            throw new UnprocessableEntityException(
                "Schedule date '{$this->request->scheduleDatetime}'" 
                    . " not found to this doctor"
            );
        }
        
        $this->doctorSchedule =  $doctorSchedule;
    }
    
    private function validateDoctorSchedule(): void {
        if (!$this->doctorSchedule->available) {
            throw new UnprocessableEntityException(
                "Schedule date is not available"
            );
        }
    }
    
    private function makeSchedule(): Schedule
    {
        return $this->scheduleFactory->make(
            $this->pacient, 
            $this->doctor, 
            $this->scheduleDateTime
        );
    }
    
    private function registerSchedule(Schedule $schedule): void
    {
        $this->scheduleRepository->create($schedule);
    }
    
    private function makeResponse(Schedule $schedule): CreateScheduleResponse
    {
        return new CreateScheduleResponse(
            $schedule->pacient->phone,
            $schedule->pacient->name,
            $schedule->doctor->id,
            $schedule->dateTime->format('Y-m-d H:i:s'),
            $schedule->createdAt->format('Y-m-d H:i:s')
        );
    }
}
