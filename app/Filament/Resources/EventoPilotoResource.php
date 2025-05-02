<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventoPilotoResource\Pages;
// Asegúrate de importar los Resources de Pilotos y Eventos si vas a usar Actions\ViewAction
use App\Filament\Resources\PilotosResource;
use App\Filament\Resources\EventosResource;
use App\Models\EventoPiloto;
use App\Models\Pilotos;
use App\Models\Eventos;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action; // Necesario para acciones personalizadas
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group; // Necesario para agrupar
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon; // Para formateo de fechas en filtros

class EventoPilotoResource extends Resource
{
    protected static ?string $model = EventoPiloto::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    // --- MÉTODO FORM (sin cambios) ---
    public static function form(Form $form): Form
    {
         return $form
            ->schema([
                Forms\Components\Select::make('piloto_id')
                    ->label('Piloto')
                    ->relationship('piloto')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->Nombre} {$record->Apellidos}")
                    ->searchable()
                    // ->preload() // Eliminado para optimizar carga inicial
                    ->required(),
                Forms\Components\Select::make('evento_id')
                    ->label('Evento')
                    ->relationship('evento', 'Nombre')
                    ->searchable()
                    // ->preload() // Eliminado para optimizar carga inicial
                    ->required(),
                Forms\Components\DatePicker::make('fecha_registro')
                    ->label('Fecha de Registro')
                    ->required(),
            ]);
    }

    // --- MÉTODO TABLE (con filtros sin preload) ---
    public static function table(Table $table): Table
    {
        return $table
             // --- Ordenación por defecto ---
            ->defaultSort('fecha_registro', 'desc')

            // --- Columnas (sin cambios) ---
            ->columns([
                TextColumn::make('piloto.Nombre')
                    ->label('Piloto Nombre')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('piloto', fn(Builder $q) => $q
                            ->where('Nombre', 'like', "%{$search}%")
                            ->orWhere('Apellidos', 'like', "%{$search}%"));
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                         return $query->orderBy(
                             Pilotos::select('Nombre')->whereColumn('pilotos.id', 'evento_piloto.piloto_id'), $direction
                         );
                    }),
                 TextColumn::make('piloto.Apellidos')
                    ->label('Piloto Apellidos')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('piloto', fn(Builder $q) => $q->where('Apellidos', 'like', "%{$search}%"));
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                         return $query->orderBy(
                             Pilotos::select('Apellidos')->whereColumn('pilotos.id', 'evento_piloto.piloto_id'), $direction
                         );
                    }),
                TextColumn::make('evento.nombre')
                    ->label('Evento')
                    ->searchable()
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                         return $query->orderBy(
                             Eventos::select('Nombre')->whereColumn('eventos.id', 'evento_piloto.evento_id'), $direction
                         );
                    })
                    ->hidden(fn (Table $table): bool => $table->getGrouping()?->getId() === 'evento.nombre'),
                TextColumn::make('fecha_registro')
                    ->label('Fecha Registro')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            // --- Filtros (sin preload) ---
            ->filters([
                SelectFilter::make('piloto_id')
                    ->label('Filtrar por Piloto')
                    ->relationship('piloto', 'Nombre')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->Nombre} {$record->Apellidos}")
                    ->searchable(), // Preload eliminado
                    // ->preload(),

                SelectFilter::make('evento_id')
                    ->label('Filtrar por Evento')
                    ->relationship('evento', 'Nombre')
                    ->searchable(), // Preload eliminado
                    // ->preload(),

                Filter::make('fecha_registro')
                    ->form([
                        DatePicker::make('registrado_desde')->label('Registrado Desde'),
                        DatePicker::make('registrado_hasta')->label('Registrado Hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['registrado_desde'], fn (Builder $query, $date): Builder => $query->whereDate('fecha_registro', '>=', $date))
                            ->when($data['registrado_hasta'], fn (Builder $query, $date): Builder => $query->whereDate('fecha_registro', '<=', $date));
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['registrado_desde'] ?? null) {
                            $indicators['registrado_desde'] = 'Registrado desde ' . Carbon::parse($data['registrado_desde'])->translatedFormat('d M Y');
                        }
                        if ($data['registrado_hasta'] ?? null) {
                            $indicators['registrado_hasta'] = 'Registrado hasta ' . Carbon::parse($data['registrado_hasta'])->translatedFormat('d M Y');
                        }
                        return $indicators;
                    }),
            ])
            ->actions([
                // Opcional: Acción para ver detalles
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(), // Añadir acción de borrar
            ])
            // --- Acciones Masivas (sin cambios) ---
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            // --- Agrupación (sin cambios) ---
            ->groups([
                Group::make('evento.nombre')
                    ->label('Evento')
                    ->collapsible(),
            ])
            ->defaultGroup('evento.nombre');
    }

    // --- AÑADIR ESTE MÉTODO PARA EAGER LOADING ---
    public static function getEloquentQuery(): Builder
    {
        // Carga las relaciones 'piloto' y 'evento' junto con la consulta principal
        return parent::getEloquentQuery()->with(['piloto', 'evento']);
    }

    // ... resto de métodos (getRelations, getPages) ...
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEventoPilotos::route('/'),
            'create' => Pages\CreateEventoPiloto::route('/create'),
            'edit' => Pages\EditEventoPiloto::route('/{record}/edit'),
        ];
    }
}
