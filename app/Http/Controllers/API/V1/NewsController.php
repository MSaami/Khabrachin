<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsCollection;
use App\Models\News;
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
            'order_by' => 'nullable|in:' .  implode(',', News::ORDERABLE_FIELDS),
            'order_direction' => 'nullable|in:asc,desc',
        ]);


        $dto = $request->query() ? $this->queryParamToDto($request) : $this->userPreferencesToDto();

        return response()->json(
            new NewsCollection($this->newsRepository->getNews($dto))
        );
    }


    private function queryParamToDto(Request $request)
    {
        $dto = new NewsFilterDTO;

        $dto->sources = $request->sources ? explode(',', $request->sources) : [];
        $dto->categories = $request->categories ? explode(',', $request->categories) : [];
        $dto->date_from = $request->date_from ? Carbon::parse($request->date_from) : null;
        $dto->date_to = $request->date_to ? Carbon::parse($request->date_to) : null;
        $dto->search = $request->search;
        $dto->authors = $request->authors ? explode(',', $request->authors) : [];


        if ($request->has('order_by')) {
            $dto->order_by = $request->order_by;
        }
        if ($request->has('order_direction')) {
            $dto->order_direction = $request->order_direction;
        }




        return $dto;
    }

    private function userPreferencesToDto()
    {
        $dto = new NewsFilterDTO;

        $dto->categories = auth()->user()->preferences?->category_ids;
        $dto->sources = auth()->user()->preferences?->sources;
        $dto->authors = auth()->user()->preferences?->authors;

        return $dto;
    }
}
