<?php

namespace AhmedShaan\FilamentApprovalWorkflow;

use Filament\Contracts\Plugin;
use Filament\Panel;
use YourVendor\FilamentApprovalWorkflow\Interfaces\Stateable;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Queue;

class FilamentApprovalWorkflowPlugin implements Plugin
{
    protected static $jobClasses = [];

    public function getId(): string
    {
        return "filament-approval-workflow";
    }

    public function register(Panel $panel): void
    {
        //
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return new static();
    }

    public static function getStateColumn(): IconColumn
    {
        return IconColumn::make("state")
            ->icon(fn(Stateable $record): string => $record->getStateIcon())
            ->color(fn(Stateable $record): string => $record->getStateColor())
            ->label(fn(Stateable $record): string => $record->getStateLabel());
    }

    public static function getTableActions(): array
    {
        return [
            TableAction::make("pending")
                ->icon("heroicon-o-clock")
                ->color("warning")
                ->action(
                    fn(Stateable $record) => static::executeStateChange(
                        $record,
                        "pending"
                    )
                )
                ->requiresConfirmation()
                ->visible(
                    fn(Stateable $record) => $record->getState() !== "pending"
                ),

            TableAction::make("verify")
                ->icon("heroicon-o-check-circle")
                ->color("info")
                ->action(
                    fn(Stateable $record) => static::executeStateChange(
                        $record,
                        "verify"
                    )
                )
                ->requiresConfirmation()
                ->visible(
                    fn(Stateable $record) => $record->getState() === "pending"
                ),

            TableAction::make("approve")
                ->icon("heroicon-o-badge-check")
                ->color("success")
                ->action(
                    fn(Stateable $record) => static::executeStateChange(
                        $record,
                        "approve"
                    )
                )
                ->requiresConfirmation()
                ->visible(
                    fn(Stateable $record) => $record->getState() === "verified"
                ),

            TableAction::make("reject")
                ->icon("heroicon-o-x-circle")
                ->color("danger")
                ->action(
                    fn(Stateable $record) => static::executeStateChange(
                        $record,
                        "reject"
                    )
                )
                ->requiresConfirmation()
                ->visible(
                    fn(Stateable $record) => in_array($record->getState(), [
                        "pending",
                        "verified",
                    ])
                ),
        ];
    }

    public static function getFormActions(): array
    {
        return [
            FormAction::make("pending")
                ->icon("heroicon-o-clock")
                ->color("warning")
                ->action(
                    fn(Stateable $record) => static::executeStateChange(
                        $record,
                        "pending"
                    )
                )
                ->visible(
                    fn(Stateable $record) => $record->getState() !== "pending"
                ),

            FormAction::make("verify")
                ->icon("heroicon-o-check-circle")
                ->color("info")
                ->action(
                    fn(Stateable $record) => static::executeStateChange(
                        $record,
                        "verify"
                    )
                )
                ->visible(
                    fn(Stateable $record) => $record->getState() === "pending"
                ),

            FormAction::make("approve")
                ->icon("heroicon-o-badge-check")
                ->color("success")
                ->action(
                    fn(Stateable $record) => static::executeStateChange(
                        $record,
                        "approve"
                    )
                )
                ->visible(
                    fn(Stateable $record) => $record->getState() === "verified"
                ),

            FormAction::make("reject")
                ->icon("heroicon-o-x-circle")
                ->color("danger")
                ->action(
                    fn(Stateable $record) => static::executeStateChange(
                        $record,
                        "reject"
                    )
                )
                ->visible(
                    fn(Stateable $record) => in_array($record->getState(), [
                        "pending",
                        "verified",
                    ])
                ),
        ];
    }

    protected static function executeStateChange(
        Stateable $record,
        string $action
    ): void {
        $record->$action();
        Notification::make()
            ->success(ucfirst($action) . " successfully")
            ->send();

        if (isset(static::$jobClasses[$action])) {
            $jobClass = static::$jobClasses[$action];
            Queue::push(new $jobClass($record));
        }
    }

    public static function registerJob(string $action, string $jobClass): void
    {
        static::$jobClasses[$action] = $jobClass;
    }
}
