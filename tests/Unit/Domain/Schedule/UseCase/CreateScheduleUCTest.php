<?php

namespace Tests\Unit\Domain\Schedule\UseCase;

use Agendanet\App\Commons\Http\Exceptions\UnprocessableEntityException;
use Agendanet\Domain\Doctor\Repository\DoctorRepositoryInterface;
use Agendanet\Domain\Schedule\DTO\CreateScheduleRequest;
use Agendanet\Domain\Schedule\UseCase\CreateScheduleUC;
use PHPUnit\Framework\TestCase;

final class CreateScheduleUCTest extends TestCase
{
    private DoctorRepositoryInterface $doctorRepositoryMock;
    
    public function setUp(): void
    {
        $this->doctorRepositoryMock = $this->createMock(
            DoctorRepositoryInterface::class
        );
        parent::setUp();
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
        $expectedErrorMessage = "Doctor not found by id:{$createScheduleRequest->doctorId}";
        $this->expectException(UnprocessableEntityException::class);
        $this->expectExceptionMessage($expectedErrorMessage);
        
        $createScheduleUC->execute($createScheduleRequest);
    }
    
    private function getCreateScheduleUC(): CreateScheduleUC
    {
        return new CreateScheduleUC($this->doctorRepositoryMock);
    }
    
    private function getCreateScheduleRequest(): CreateScheduleRequest
    {
        return new CreateScheduleRequest(
            '41988887777',
            'John Doe',
            'aaa-123',
            '2022-12-31 23:59:00'
        );
    }
}
