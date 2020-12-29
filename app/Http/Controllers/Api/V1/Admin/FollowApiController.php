<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFollowRequest;
use App\Http\Requests\UpdateFollowRequest;
use App\Http\Resources\Admin\FollowResource;
use App\Models\Follow;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FollowApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('follow_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FollowResource(Follow::advancedFilter());
    }

    public function store(StoreFollowRequest $request)
    {
        $follow = Follow::create($request->validated());

        return (new FollowResource($follow))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create(Follow $follow)
    {
        abort_if(Gate::denies('follow_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'meta' => [
                'is_following' => Follow::IS_FOLLOWING_RADIO,
            ],
        ]);
    }

    public function show(Follow $follow)
    {
        abort_if(Gate::denies('follow_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FollowResource($follow);
    }

    public function update(UpdateFollowRequest $request, Follow $follow)
    {
        $follow->update($request->validated());

        return (new FollowResource($follow))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(Follow $follow)
    {
        abort_if(Gate::denies('follow_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'data' => new FollowResource($follow),
            'meta' => [
                'is_following' => Follow::IS_FOLLOWING_RADIO,
            ],
        ]);
    }

    public function destroy(Follow $follow)
    {
        abort_if(Gate::denies('follow_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $follow->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
