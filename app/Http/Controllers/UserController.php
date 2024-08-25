<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Fetch and validate 'perPage' and 'page' parameters
    $perPage = $request->query('perPage', 5);
    $page = $request->query('page', 1);

    $fails = [];

    // Validate 'perPage'
    if (!is_numeric($perPage) || (int)$perPage <= 0) {
        $fails['count'] = 'The count must be a positive integer';
    }

    // Validate 'page'
    if (!is_numeric($page) || (int)$page < 1) {
        $fails['page'] = 'The page must be at least 1';
    }
    if (!is_numeric($page) || (int)$page >  User::count()/$perPage ) {
        $users = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 1);

        return Inertia::render('Guest/Users/Index', [
            'usersResponse' => [
                'success' => false,
                'page' => 0,
                'count' => $users->count(),
                'total_pages' => 0,
                'total_users' => 0,
                'links' => [
                    'next_url' => null,
                    'prev_url' => null
                ],
                'users' => [],
            ],
            'usersResponse404' => [
                'success' => false,
                'message' => 'The page does not exist: the page number is too high'
            ],
        ]);
    }

    // If there are validation errors, return them with an empty user set
    if (!empty($fails)) {
        $users = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 1);

        return Inertia::render('Guest/Users/Index', [
            'usersResponse' => [
                'success' => false,
                'page' => 0,
                'count' => $perPage,
                'total_pages' => 0,
                'total_users' => 0,
                'links' => [
                    'next_url' => null,
                    'prev_url' => null
                ],
                'users' => [],
            ],
            'usersResponse422' => [
                'success' => false,
                'message' => 'Validation failed',
                'fails' => $fails,
            ],
        ]);
    }

    // Fetch the users with the validated perPage and page values
    $users = User::paginate((int)$perPage, ['*'], 'page', (int)$page);

    return Inertia::render('Guest/Users/Index', [
        'usersResponse' => [
            'success' => true,
            'page' => $users->currentPage(),
            'count' => $users->count(),
            'total_pages' => $users->lastPage(),
            'total_users' => $users->total(),
            'links' => [
                'next_url' => $users->nextPageUrl(),
                'prev_url' => $users->previousPageUrl(),
            ],
            'users' => UserResource::collection($users),
        ],
    ]);
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
    public function show(Request $request)
    {
        $fails = [];

        try {
         
            $user = User::findOrFail($request->id);
            return Inertia::render('Guest/Users/Show', [
                'userResponse' => [
                    'success'=> true,
                    'user' => $user
                ],
            ]);
        } catch (ModelNotFoundException $e) {
            
            if(!is_numeric($request->id) || $request->id < 0){

                return Inertia::render('Guest/Users/Show', [
                    'userResponse422' => [
                        'success'=> false,
                        'message'=> 'User ID must be a positive integer'
                    ],
                    'userResponse' => [],
                ]);
            }
            return Inertia::render('Guest/Users/Show', [
                'userResponse404' => [
                    'success'=> false,
                    'message'=> 'This user does not exist'
                ],
                'userResponse' => [],
            ]);
        }


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
