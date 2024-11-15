<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Operations;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class MainController extends Controller
{
    public function index() {

        // usuario logados
        $id = session('user.id');
        $user = User::find($id)->toArray();
        $notes = User::find($id)->note()->get()->toArray();

        return view('home', ['notes' => $notes]);
    }

    public function newNote() {
        echo "create new note";
    }

    public function editNote($id) {

        $id = Operations::decryptId($id);
        echo "edit note-$id";
    }
   
    public function deletNote($id) {

       $id = Operations::decryptId($id);
        echo "delet note-$id";
    }
}
