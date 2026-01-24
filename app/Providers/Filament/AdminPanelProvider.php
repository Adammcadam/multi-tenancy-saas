<?php

namespace App\Providers\Filament;

use App\Http\Middleware\EnsureActiveOrganisation;
use App\Services\OrganisationContext;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                EnsureActiveOrganisation::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->userMenuItems([
                Action::make('currentOrganization')
                    ->label(fn () =>
                        app(OrganisationContext::class)->current()?->name ?? 'No Organisation'
                    )
                    ->icon(Heroicon::OutlinedBuildingOffice2)
                    ->visible(fn () =>
                        app(OrganisationContext::class)->current() !== null
                    )
                    ->disabled(),
                Action::make('switchOrganisation')
                    ->label('Switch Organisation')
                    ->icon(Heroicon::OutlinedBuildingOffice)
                    ->schema([
                        Select::make('organisation_id')
                            ->label('Organisation')
                            ->options(fn () =>
                                auth()->user()
                                    ->organisations
                                    ->pluck('name', 'id')
                                )
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        app(OrganisationContext::class)
                            ->set(
                                auth()->user()
                                    ->organisations()
                                    ->findOrFail($data['organisation_id'])
                            );
                        return redirect(request()->header('Referer'));
                    })
                    ->visible(fn () =>
                        auth()->user()->organisations()->count() > 1
                    ),
            ]);
    }
}
