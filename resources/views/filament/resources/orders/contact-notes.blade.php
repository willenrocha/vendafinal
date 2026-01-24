<div class="space-y-4">
    <div class="grid grid-cols-2 gap-4">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Contatado em:</p>
            <p class="text-sm text-gray-900 dark:text-gray-100">
                {{ $record->contacted_at?->format('d/m/Y H:i') ?? '—' }}
            </p>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Contatado por:</p>
            <p class="text-sm text-gray-900 dark:text-gray-100">
                {{ $record->contacted_by ?? '—' }}
            </p>
        </div>
    </div>

    <div>
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Notas:</p>
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
            <p class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap">
                {{ $record->contact_notes ?? 'Sem notas registradas.' }}
            </p>
        </div>
    </div>
</div>
