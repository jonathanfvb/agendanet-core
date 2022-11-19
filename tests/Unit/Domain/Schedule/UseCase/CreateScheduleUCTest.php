<?php

namespace Tests\Unit\Domain\Schedule\UseCase;

use Agendanet\App\Commons\Http\Exceptions\UnprocessableEntityException;
use Agendanet\Domain\Doctor\Repository\DoctorRepositoryInterface;
use Agendanet\Domain\Doctor\Repository\DoctorScheduleRepositoryInterface;
use Agendanet\Domain\Schedule\DTO\CreateScheduleRequest;
use Agendanet\Domain\Schedule\Factory\ScheduleFactoryInterface;
use Agendanet\Domain\Schedule\Repository\ScheduleRepositoryInterface;
use Agendanet\Domain\Schedule\UseCase\CreateScheduleUC;
use PHPUnit\Framework\TestCase;
use Agendanet\App\Commons\Http\Exceptions\BadRequestException;
use Agendanet\Domain\Doctor\Entity\Doctor;
use Agendanet\Domain\Doctor\Entity\DoctorSchedule;

final class CreateScheduleUCTest extends TestCase
{
    private DoctorRepositoryInterface $doctorRepositoryMock;
    
    private DoctorScheduleRepositoryInterface $doctorScheduleRepositoryMock;
    
    private ScheduleRepositoryInterface $scheduleRepositoryMock;
    
    private ScheduleFactoryInterface $scheduleFactoryMock;
    
    public function setUp(): void
    {
        $this->doctorRepositoryMock = $this->createMock(
            DoctorRepositoryInterface::class
        );
        $this->doctorScheduleRepositoryMock = $this->createMock(
            DoctorScheduleRepositoryInterface::class
        );
        $this->scheduleRepositoryMock = $this->createMock(
            ScheduleRepositoryInterface::class
        );
        $this->scheduleFactoryMock = $this->createMock(
            ScheduleFactoryInterface::class
        );
        parent::setUp();
    }
    
    public function testWhenScheduleDatetimeHasIncorrectFormatShouldThrowsBadRequestException(): void
    {
        // ARRANGE
        $this->doctorRepositoryMock
            ->method('findByDoctorId')
            ->willReturn(null);
        $createScheduleRequest = $this->getCreateScheduleRequest();
        $createScheduleRequest->scheduleDatetime = '2022-12-31 23:59:00';
        $createScheduleUC = $this->getCreateScheduleUC();
        
        // ACT & ASSERT
        $expectedErrorMessage = "Schedule datetime is not in the expected ";
        $expectedErrorMessage.= "format 'Y-m-d H:i'";
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage($expectedErrorMessage);
        
        $createScheduleUC->execute($createScheduleRequest);
    }
    
    public function testWhenDoctorNotExistsShouldThrowsUnprocessableEntityException(): void
    {
        // ARRANGE
        $this->doctorRepositoryMock
        ->method('findByDoctorId')
        ->willReturn(null);
        $createScheduleRequest = $this->getCreateScheduleRequest();
        $createScheduleUC = $this->getCreateScheduleUC();
        
        // ACT & ASSERT
        $expectedErrorMessage = "Doctor not found by ";
        $expectedErrorMessage.= "id:{$createScheduleRequest->doctorId}";
        $this->expectException(UnprocessableEntityException::class);
        $this->expectExceptionMessage($expectedErrorMessage);
        
        $createScheduleUC->execute($createScheduleRequest);
    }
    
    public function testWhenDoctorScheduleNotExistsShouldThrowsUnprocessableEntityException(): void
    {
        // ARRANGE
        $this->doctorRepositoryMock
            ->method('findByDoctorId')
            ->willReturn(new Doctor('123'));
        
        $this->doctorScheduleRepositoryMock
            ->method('findSchedule')
            ->willReturn(null);
        
        $createScheduleRequest = $this->getCreateScheduleRequest();
        $createScheduleUC = $this->getCreateScheduleUC();
        
        // ACT & ASSERT
        $expectedErrorMessage = "Schedule date ";
        $expectedErrorMessage.= "'{$createScheduleRequest->scheduleDatetime}'";
        $expectedErrorMessage.= " not found to this doctor";
        $this->expectException(UnprocessableEntityException::class);
        $this->expectExceptionMessage($expectedErrorMessage);
        
        $createScheduleUC->execute($createScheduleRequest);
    }
    
    public function testWhenDoctorScheduleIsNotAvailableShouldThrowsUnprocessableEntityException(): void
    {
        // ARRANGE
        $doctor = new Doctor('123');
        $this->doctorRepositoryMock
            ->method('findByDoctorId')
            ->willReturn($doctor);
        
        $this->doctorScheduleRepositoryMock
            ->method('findSchedule')
            ->willReturn(new DoctorSchedule($doctor, new \DateTime(), false));
        
        $createScheduleRequest = $this->getCreateScheduleRequest();
        $createScheduleUC = $this->getCreateScheduleUC();
        
        // ACT & ASSERT
        $expectedErrorMessage = "Schedule date is not available";
        $this->expectException(UnprocessableEntityException::class);
        $this->expectExceptionMessage($expectedErrorMessage);
        
        $createScheduleUC->execute($createScheduleRequest);
    }
    
    private function getCreateScheduleUC(): CreateScheduleUC
    {
        return new CreateScheduleUC(
            $this->doctorRepositoryMock,
            $this->doctorScheduleRepositoryMock,
            $this->scheduleRepositoryMock,
            $this->scheduleFactoryMock
        );
    }
    
    private function getCreateScheduleRequest(): CreateScheduleRequest
    {
        return new CreateScheduleRequest(
            '41988887777',
            'John Doe',
            'aaa-123',
            '2022-12-31 23:59'
        );
    }
}
