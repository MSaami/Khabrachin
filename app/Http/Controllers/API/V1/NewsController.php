<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsCollection;
use App\Models\UserPreferences;
use App\Repositories\NewsFilterDTO;
use App\Repositories\NewsRepository;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct(protected NewsRepository $newsRepository) {}

    public function index(Request $request)
    {
        $request->validate([
            'date_from' => 'nullable|date_format:Y-m-d',
            'date_to' => 'nullable|date_format:Y-m-d',
        ]);

        $dto = $this->createNewsFilterDTO($request);

        return response()->json(
            new NewsCollection($this->newsRepository->getNews($dto))
        );
    }

    protected function createNewsFilterDTO(Request $request): NewsFilterDTO
    {
        $dto = new NewsFilterDTO;

        if ($request->all()) {
            $dto->sources = $request->sources ? explode(',', $request->sources) : [];
            $dto->categories = $request->categories ? explode(',', $request->categories) : [];
            $dto->date_from = $request->date_from ? Carbon::parse($request->date_from) : null;
            $dto->date_to = $request->date_to ? Carbon::parse($request->date_to) : null;
            $dto->search = $request->search;
        } else {
            $dto->categories = $request->user()->preferences?->category_ids;
            $dto->sources = $request->user()->preferences?->sources;
        }


        return $dto;
    }
}
