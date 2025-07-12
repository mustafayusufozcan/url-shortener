<?php

namespace App\Http\Controllers;

use App\Data\Url\RedirectUrlData;
use App\Data\Url\ShortenUrlData;
use App\Http\Requests\Url\PaginateRequest;
use App\Http\Requests\Url\ShortenRequest;
use App\Http\Resources\Url\UrlResource;
use App\Models\Url\Url;
use App\Services\UrlService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private readonly UrlService $urlService) {}

    /**
     * @param PaginateRequest $request
     * 
     * @return JsonResponse
     */
    public function index(PaginateRequest $request): JsonResponse
    {
        $urls = $this->urlService->getAll();

        return $this->successResponse(
            data: [
                'urls' => UrlResource::collection($urls),
                'next' => $urls->nextPageUrl(),
                'previous' => $urls->previousPageUrl(),
            ]
        );
    }

    public function show(Url $url): JsonResponse
    {
        $this->authorize('view', $url);

        $url = $this->urlService->get($url);

        return $this->successResponse(
            data: [
                'url' => new UrlResource($url),
            ]
        );
    }

    public function shorten(ShortenRequest $request): JsonResponse
    {
        $data = ShortenUrlData::from($request->validated());
        $url = $this->urlService->shorten($data);

        return $this->successResponse(
            data: [
                'url' => new UrlResource($url),
            ],
            status: 201
        );
    }

    public function destroy(Url $url): JsonResponse
    {
        $this->authorize('delete', $url);

        $this->urlService->delete($url);

        return $this->noContentResponse();
    }

    public function redirect(Request $request, string $code): RedirectResponse
    {
        $data = RedirectUrlData::from([
            'code' => $code,
            'ipAddress' => $request->ip(),
            'userAgent' => $request->userAgent(),
            'referer' => $request->header('referer'),
        ]);

        $url = $this->urlService->redirect($data);

        return redirect()->away($url->url);
    }
}
