<?php

namespace App\Http\Controllers;

use App\Services\Firebase;
use Illuminate\Http\Request;

class FirestoreController extends Controller
{

    protected $firestore;

    public function __construct()
    {
        $this->firestore = (new Firebase)->firestoreDb;
    }

    public function store(Request $request)
    {
        $collection = $this->firestore->collection('users')->newDocument();

        $collection->set($request->all());
        return response()->json([]);
    }

    public function index()
    {
        $collection = $this->firestore->collection('users')->where('status', '=', 'online')->documents();
        $data = [];
        foreach ($collection as $user) {
            $data[] = $user->data();
        }

        return response()->json(compact('data'));
    }

    public function update()
    {
        $collection = $this->firestore->collection('users')->document('1');

        $collection->set([
            'status' => 'offline'
        ], ['merge'=>true]);

        return response()->json();
    }

    public function destroy()
    {

        $batch = $this->firestore->batch();

        $collection = $this->firestore->collection('users')->where('status', '=', 'online')->documents();

        foreach ($collection as $user) {
            $batch->delete($user->reference());
        }

        $batch->commit();

        return response()->json(status:204);
    }
}
