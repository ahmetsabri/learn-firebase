<?php

namespace App\Http\Controllers;

use App\Services\Firebase;
use Illuminate\Http\Request;

class DatabaseController extends Controller
{

    protected $db;

    public function __construct()
    {
        $this->db = (new Firebase)->realtimeDatabase;
    }

    public function store(Request $request)
    {
        $ref = $this->db->getReference('users');

        $ref->push($request->all());

        return response()->json();
    }

    public function index()
    {
        $ref = $this->db->getReference('users');

        $users = $ref->orderByChild('age')->endAt(25)->limitToLast(10)->getValue();

        return response()->json(compact('users'));
    }

    public function update()
    {
        $ref = $this->db->getReference('users');

        $user = $ref->orderByChild('id')->equalTo(1)->getValue();

        $key = array_key_first($user);

        $userRef = $this->db->getReference('users/'.$key.'/status');

        $userRef->set('offline');
        return response()->json();
    }

    public function delete()
    {
        $ref = $this->db->getReference('users');

        $ref->set(null);

        return response()->json(status:204);
    }
}
