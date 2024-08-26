<?php

namespace App\Http\Controllers;

use Error;
use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Token;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\RegistrationRequest;
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
        $fails['count'] = 'The count must be a positive integer.';
    }

    // Validate 'page'
    if (!is_numeric($page) || (int)$page < 1 || (int)$page >  ceil(User::count()/$perPage) ) {
        $fails['page'] = 'The page must be at least 1 and not beyond the total amount o users.';
    }

    if(!empty($fails))
    return Inertia::render('Guest/Users/Index', [
        'usersResponse' => [
            'success' => false,
            'page' => 1,
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
            'message' => 'The page does not exist: the page number is too high.',
            'fails'=> $fails
        ],
    ]);


    if ((int)$page >  User::count()/$perPage + $perPage) {
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
            'count' => $perPage,
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


    // public function access(Request $request){

    //     $token = Str::random(60);

    //     Cache::put('access_token_' . $token, true, now()->addMinutes(40));

    //     return response()->json(['token' => $token]);
    // }

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
    public function store(RegistrationRequest $request)
{
    $validatedData = $request->validated();

    $imgPath = null;
    try {
        if ($request->hasFile('photo')) {
            $originalImagePath = $request->file('photo')->store('profile_images', 'public');
            $this->resizeAndCompressImage(storage_path('app/public/' . $originalImagePath));
            $imgPath = $originalImagePath;
        }

        // return response()->json(['message' => 'access_token_'.Token::first()->id_], 401);
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'photo' => $imgPath,
            'phone'=>$validatedData['phone'],
            'position_id'=>$validatedData['position_id'],
            'email_verified_at'=>Carbon::now()
        ]);
        
        \Log::info('User registered successfully: ' . $user->email);
        setcookie('access_token_'.Token::first()->id_, '', -1, '/');
        Token::truncate();
        return redirect('/users')->with('success', 'Registration successful.');

    } catch (\Exception $e) {
        \Log::error('Registration error: ' . $e->getMessage());
        return redirect('/users')->withErrors('Registration failed. Please try again.');
    }
}



    protected function resizeAndCompressImage($imagePath)
    {
        try {
            \Tinify\setKey(env('TINYPNG_API_KEY'));

            $source = \Tinify\fromFile($imagePath);
            
            // Resize the image
            $resized = $source->resize([
                "method" => "cover",
                "width" => 70,
                "height" => 70
            ]);
            
      
            $resized->toFile($imagePath);
        } catch (\Exception $e) {
            \Log::error('TinyPNG error: ' . $e->getMessage());
        }
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
