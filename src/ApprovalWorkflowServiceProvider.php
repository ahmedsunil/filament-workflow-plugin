<?php

namespace AhmedShaan\FilamentApprovalWorkflow;

use Filament\Support\Providers\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class ApprovalWorkflowServiceProvider extends PluginServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-approval-workflow')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations([
                'create_approval_workflow_tables',
            ]);
    }
}
