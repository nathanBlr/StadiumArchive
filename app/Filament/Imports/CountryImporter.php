<?php

namespace App\Filament\Imports;

use App\Models\Country;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Http\UploadedFile;

class CountryImporter extends Importer
{
    
    protected static ?string $model = Country::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
        ];
    }

    public function handle(UploadedFile $file)
    {
        $mimeType = $file->getClientMimeType();

        if (!in_array($mimeType, ['text/csv', 'text/x-csv', 'application/csv'])) {
            throw new \Exception('Invalid file type. Please upload a CSV file.');
        }

        parent::handle($file);
    }

    public function resolveRecord(): ?Country
    {
        return Country::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
             'name' => $this->data['name'],
         ]);
        return new Country();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your country import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
