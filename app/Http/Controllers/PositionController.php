<?php

namespace App\Http\Controllers;


use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use App\Models\Position;
use App\Repositories\PositionRepository;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class PositionController extends Controller
{

    /**
     * @var PositionRepository
     */
    private PositionRepository $positionRepository;

    /**
     *
     */
    public function __construct()
    {
        $this->middleware('role:super_admin|hr_admin')->only('update', 'store', 'destroy');
        $this->positionRepository = new PositionRepository();
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->success($this->positionRepository->all())->send();
    }

    /**
     * @param StorePositionRequest $request
     * @return JsonResponse
     */
    public function store(StorePositionRequest $request): JsonResponse
    {
        return $this->success($this->positionRepository->create($request->validated()))->send();
    }

    /**
     * @param Position $position
     * @return JsonResponse
     */
    public function show(Position $position): JsonResponse
    {
        return $this->success($position)->send();
    }

    /**
     * @param UpdatePositionRequest $request
     * @param Position $department
     * @return JsonResponse
     */
    public function update(UpdatePositionRequest $request, Position $department): JsonResponse
    {
        $this->positionRepository->update($department->id, $request->validated());
        return $this->success($department->refresh())->send();
    }

    /**
     * @param Position $position
     * @return JsonResponse
     */
    public function destroy(Position $position): JsonResponse
    {
        return $this->success($position->delete())->send();
    }
}