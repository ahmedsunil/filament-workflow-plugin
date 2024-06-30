<?php

namespace AhmedShaan\FilamentApprovalWorkflow\Traits;

use Filament\Forms;
use AhmedShaan\FilamentApprovalWorkflow\FilamentApprovalWorkflowPlugin;

trait HasApprovalWorkflowForm
{
    public function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make("state")
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
