<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateProfileRequest;
use App\Http\Resources\ProfileResource;
use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    public function __construct(
        protected Profile $repository,
    ) 
    {

    }

    public function index()
    {
        $profile = $this->repository->paginate();

        
        return ProfileResource::collection($profile);
    }

    public function store(StoreUpdateProfileRequest $request)
    {
        $data = $request->validated();
        // $data['password'] = bcrypt($request->password);
        $profile = $this->repository->create($data);

        return new ProfileResource($profile);
        // Profile::create($this->repository);

        // return redirect('profile');
    }

    public function show(string $id)
    {
        // $user = $this->repository->find($id);
        // $user = $this->repository->where('id', '=', $id)->first();
        // if (!$user) {
        //     return response()->json(['message' => 'user not found'], 404);
        // }

        $profile = Profile::findOrFail($id);

        // dd($user);

        
        return new ProfileResource($profile);
    }

    public function update(StoreUpdateProfileRequest $request, string $id)
    {
        $profile = $this->repository->findOrFail($id);

        $data = $request->validated();

        $profile->update($data);

        return new ProfileResource($profile);
    }

    public function destroy(string $id)
    {
        $profile = $this->repository->findOrFail($id);
        $profile->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}