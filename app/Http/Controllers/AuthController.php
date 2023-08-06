<?php

namespace App\Http\Controllers;

use App\Services\Firebase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Auth\UserQuery;
use Kreait\Firebase\Exception\Auth\UserNotFound;

class AuthController extends Controller
{
    public $auth;

    public function __construct()
    {
        $this->auth = (new Firebase)->auth;
    }

    public function register(Request $request)
    {
        $this->auth->createUser([
            'email' => $request->email,
            'password' => $request->password,
            'displayName' => 'ahmed'
        ]);
    }

    public function login(Request $request)
    {
        $user =  $this->auth->signInWithEmailAndPassword($request->email, $request->password);
        return response()->json(['msg' => 'Logged In', 'user' => $user->data()]);
    }

    public function update(Request $request)
    {
        $this->auth->updateUser('jshjgN39MRXN30ny89AU52FiMF13', [
            'email' => $request->email,
            'password' => $request->password
        ]);

        return response()->json(['msg' => 'User Updated']);
    }

    public function disable()
    {
        $this->auth->disableUser('jshjgN39MRXN30ny89AU52FiMF13');
        return response()->json(['msg' => 'User Disabled']);
    }

    public function enable()
    {
        $this->auth->enableUser('jshjgN39MRXN30ny89AU52FiMF13');
        return response()->json(['msg' => 'User Enabled']);
    }

    public function index()
    {
        // $users = $this->auth->listUsers();
        // $users = collect($users);

        // $query = UserQuery::all()->withOffset(1)->withLimit(1)->sortedBy(UserQuery::FIELD_CREATED_AT);
        // $users = $this->auth->queryUsers($query);

        $users = $this->auth->getUsers(['bcm62KoRz1Wc4RVBGWTFPEAFBdk2',2,3]);
        return response()->json(compact('users'));
    }

    public function show(Request $request)
    {
        try {
            $user = $this->auth->getUserByEmail($request->email);
        } catch (UserNotFound $th) {
            Log::info($th->getMessage());
            abort(404);
        }
        return response()->json(compact('user'));
    }

    public function delete()
    {
        $user = $this->auth->deleteUsers(['kuOynU3nP1Sk76b7rEYcBGzCGod2', 'bcm62KoRz1Wc4RVBGWTFPEAFBdk2'], true);

        return response()->json([], 204);
    }
}
