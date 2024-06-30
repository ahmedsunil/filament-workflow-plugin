<?php

namespace Ahmedshaan\FilamentApprovalWorkflow\Interfaces;

interface Stateable
{
    public function pending(): void;

    public function verify(): void;

    public function approve(): void;

    public function reject(): void;

    public function getState(): string;

    public function getStateIcon(): string;

    public function getStateLabel(): string;

    public function getStateColor(): string;
}
