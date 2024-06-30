<?php

namespace Ahmedshaan\FilamentApprovalWorkflow\Traits;

use Ahmedshaan\FilamentApprovalWorkflow\FilamentApprovalWorkflowPlugin;
use Filament\Forms;

trait HasApprovalWorkflowForm
{
    public function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('state')
                ->options(
                    array_combine(
                        static::getPossibleStates(),
                        static::getPossibleStates()
                    )
                )
                ->disabled()
                ->dehydrated(false),
            Forms\Components\Actions::make(
                FilamentApprovalWorkflowPlugin::getFormActions()
            ),
        ];
    }
}
