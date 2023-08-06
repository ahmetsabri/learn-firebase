<?php

namespace App\Services;

use Kreait\Firebase\Factory;

class Firebase
{

    public $firebase;
    public $auth;
    public $realtimeDatabase;
    public $firestoreDb;

    public function __construct()
    {
        $this->firebase = (new Factory)->withServiceAccount(base_path('firebase.json'));

        $this->auth = $this->firebase->createAuth();

        $this->realtimeDatabase = $this->firebase
        ->withDatabaseUri(config('firebase.database_uri'))
        ->createDatabase();

        $firestore = $this->firebase->createFirestore();

        $this->firestoreDb = $firestore->database();
    }
}
