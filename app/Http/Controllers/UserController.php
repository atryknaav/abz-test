<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       
        $perPage = $request->query('perPage', 5);

        
        $perPage = is_numeric($perPage) ? (int)$perPage : 5;


        $users = User::paginate($perPage);


        $usersResponse = [
            'success' => true,
            'page' => $users->currentPage(),
            'count' => $users->count(),
            'total_pages' => $users->lastPage(),
            'total_users' => $users->total(),
            'links' => [
                'next_url' => [
                    'label' => 'Previous',
                    'url' => $users->previousPageUrl(),
                ],
                'prev_url' => [
                    'label' => 'Next',
                    'url' => $users->nextPageUrl(),
                ]
            ],
            'users' => UserResource::collection($users),
        ];

        return Inertia::render('Guest/Users', ['usersResponse' => $usersResponse]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
