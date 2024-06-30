<?php

namespace Ahmedshaan\FilamentApprovalWorkflow\Traits;

trait HasApprovalWorkflow
{
    public static function getPossibleStates(): array
    {
        return ['pending', 'verified', 'approved', 'rejected'];
    }

    public function pending(): void
    {
        $this->updateState('pending');
    }

    protected function updateState(string $newState): void
    {
        if ($this->canTransitionTo($newState)) {
            $this->state = $newState;
            $this->save();
        } else {
            throw new \Exception(
                "Invalid state transition from {$this->state} to {$newState}."
            );
        }
    }

    protected function canTransitionTo(string $newState): bool
    {
        $allowedTransitions = [
            'pending' => ['verified', 'rejected'],
            'verified' => ['approved', 'rejected'],
            'approved' => ['pending'],
            'rejected' => ['pending'],
        ];

        return in_array($newState, $allowedTransitions[$this->state] ?? []);
    }

    public function verify(): void
    {
        $this->updateState('verified');
    }

    public function approve(): void
    {
        $this->updateState('approved');
    }

    public function reject(): void
    {
        $this->updateState('rejected');
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getStateIcon(): string
    {
        return match ($this->state) {
            'pending' => 'heroicon-o-clock',
            'verified' => 'heroicon-o-check-circle',
            'approved' => 'heroicon-o-badge-check',
            'rejected' => 'heroicon-o-x-circle',
            default => 'heroicon-o-question-mark-circle',
        };
    }

    public function getStateLabel(): string
    {
        return match ($this->state) {
            'pending' => 'Pending',
            'verified' => 'Verified',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            default => 'Draft',
        };
    }

    public function getStateColor(): string
    {
        return match ($this->state) {
            'pending' => 'warning',
            'verified' => 'info',
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'gray',
        };
    }
}
