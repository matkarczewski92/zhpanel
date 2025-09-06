<?php

namespace App\Providers;

use App\Interfaces\AnimalCategoryRepositoryInterface;
use App\Interfaces\AnimalOfferRepositoryInterface;
use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\AnimalTypeRepositoryInterface;
use App\Interfaces\AnimalWinteringRepositoryInterface;
use App\Interfaces\ApiDataRepositoryInterface;
use App\Interfaces\FeedRepositoryInterface;
use App\Interfaces\LitterRepositoryInterface;
use App\Interfaces\ProjectsRepositoryInterface;
use App\Interfaces\ProjectsStagesRepositoryInterface;
use App\Repository\AnimalCategoryRepository;
use App\Repository\AnimalOfferRepository;
use App\Repository\AnimalRepository;
use App\Repository\AnimalTypeRepository;
use App\Repository\AnimalWinteringRepository;
use App\Repository\ApiDataRepository;
use App\Repository\FeedRepository;
use App\Repository\LitterRepository;
use App\Repository\ProjectsRepository;
use App\Repository\ProjectsStagesRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AnimalRepositoryInterface::class, AnimalRepository::class);
        $this->app->bind(AnimalTypeRepositoryInterface::class, AnimalTypeRepository::class);
        $this->app->bind(AnimalCategoryRepositoryInterface::class, AnimalCategoryRepository::class);
        $this->app->bind(FeedRepositoryInterface::class, FeedRepository::class);
        $this->app->bind(LitterRepositoryInterface::class, LitterRepository::class);
        $this->app->bind(AnimalWinteringRepositoryInterface::class, AnimalWinteringRepository::class);
        $this->app->bind(ApiDataRepositoryInterface::class, ApiDataRepository::class);
        $this->app->bind(ProjectsRepositoryInterface::class, ProjectsRepository::class);
        $this->app->bind(ProjectsStagesRepositoryInterface::class, ProjectsStagesRepository::class);
        $this->app->bind(AnimalOfferRepositoryInterface::class, AnimalOfferRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
