## Usage

...

3. In your Filament resource, use the plugin's actions, state column, and form components:

```php
use AhmedShaan\FilamentApprovalWorkflow\FilamentApprovalWorkflowPlugin;
use AhmedShaan\FilamentApprovalWorkflow\Traits\HasApprovalWorkflowForm;

class YourResource extends Resource
{
    use HasApprovalWorkflowForm;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // ...
                FilamentApprovalWorkflowPlugin::getStateColumn(),
            ])
            ->actions([
                ...FilamentApprovalWorkflowPlugin::getTableActions(),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Your other form fields...
                ...static::getFormSchema(),
            ]);
    }

    // ...
}
