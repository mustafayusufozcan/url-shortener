<?php

namespace App\Services;

use App\Data\Url\{RedirectUrlData, ShortenUrlData};
use App\Events\Url\Visited;
use App\Exceptions\Url\NotFoundException;
use App\Models\Url\Url;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\{Auth, Cache, Route};

class UrlService
{
    const MIN_CODE_LENGTH = 3;
    const MAX_CODE_LENGTH = 7;
    const CHARACTERS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    private ?array $routes = null;

    /**
     * Retrieves all URLs of the authenticated user, ordered by creation date descending.
     *
     * @return Collection
     */
    public function getAll(?int $page = null): Paginator
    {
        return Auth::user()->urls()->orderByDesc('created_at')->paginate(100);
    }

    /**
     * Loads the given Url model along with the count of its visits.
     *
     * @param Url $url
     * @return Url
     */
    public function get(Url $url): Url
    {
        return $url->loadCount('visits');
    }

    /**
     * Retrieves a Url model by its short code from the database.
     *
     * @param string $code
     * @return Url|null
     */
    public function getByCode(string $code): ?Url
    {
        return Url::where('code', $code)->first();
    }

    /**
     * Generates a unique short code and creates a new Url record.
     * Ensures the generated code does not conflict with reserved routes or existing codes.
     *
     * @param ShortenUrlData $data
     * @return Url
     */
    public function shorten(ShortenUrlData $data): Url
    {
        do {
            $code = $this->generateCode();
        } while ($this->isCodeReserved($code) && $this->getByCode($code));

        return $this->create($data->url, $code);
    }

    /**
     * Deletes the given Url model from the database.
     *
     * @param Url $url
     * @return void
     */
    public function delete(Url $url): void
    {
        $url->delete();
    }

    /**
     * Retrieves the Url matching the given redirect data code and triggers a visit event.
     * Throws NotFoundException if the code does not exist.
     *
     * @param RedirectUrlData $data
     * @return Url
     * @throws NotFoundException
     */
    public function redirect(RedirectUrlData $data): Url
    {
        $url = $this->getByCode($data->code);

        if (!$url) {
            throw new NotFoundException;
        }

        event(new Visited($url, $data->ipAddress, $data->userAgent, $data->referer));

        return $url;
    }

    /**
     * Creates a new Url record associated with the authenticated user.
     *
     * @param string $url
     * @param string $code
     * @return Url
     */
    private function create(string $url, string $code): Url
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return $user->urls()->create([
            'url' => $url,
            'code' => $code,
        ]);
    }

    /**
     * Retrieves all URI segments from the application's registered routes.
     * Caches the result for 1 hour.
     *
     * @return array
     */
    private function getRoutes(): array
    {
        if ($this->routes === null) {
            $this->routes = Cache::remember('routes', 60 * 60, function () {
                return collect(Route::getRoutes())->pluck('uri')->map(function ($uri) {
                    $segments = explode('/', $uri);
                    foreach ($segments as $segment) {
                        if (trim($segment) !== '') {
                            return $segment;
                        }
                    }
                    return null;
                })->filter()->unique()->toArray();
            });
        }

        return $this->routes;
    }

    /**
     * Checks if the generated short code is reserved by existing route URI segments.
     *
     * @param string $code
     * @return bool
     */
    private function isCodeReserved(string $code): bool
    {
        $routes = $this->getRoutes();

        return in_array($code, $routes, true);
    }

    /**
     * Generates a random short code string using defined characters and length limits.
     *
     * @return string
     */
    private function generateCode(): string
    {
        $length = rand(self::MIN_CODE_LENGTH, self::MAX_CODE_LENGTH);
        $charactersLength = strlen(self::CHARACTERS);
        $code = [];

        foreach (range(1, $length) as $i) {
            $code[] = self::CHARACTERS[rand(0, $charactersLength - 1)];
        }

        return implode('', $code);
    }
}
