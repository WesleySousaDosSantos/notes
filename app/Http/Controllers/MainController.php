<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index() {

        // usuario logados
        $id = session('user.id');
        $user = User::find($id)->toArray();
        $notes = User::find($id)
            ->note()
            ->whereNull('deleted_at')
            ->get()
            ->toArray();

        return view('home', ['notes' => $notes]);
    }

    public function newNote() {
        // mostrar nova visualização de nota
        return view('new_note');
    }

    public function newNoteSubmit(Request $request) {
        // validar a resposta
        $request->validate(
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000',
            ],
            // mensagem de erros
            [
                'text_title.required' => 'O titulo é obrigatório',
                'text_title.min' => 'A titulo deve ter pelo menos :min caracteres',
                'text_title.max' => 'A titulo deve ter no máximo :max caracteres',
                'text_note.required' => 'A nota é obrigatório',
                'text_note.min' => 'A nota deve ter pelo menos :min caracteres',
                'text_note.max' => 'A nota deve ter no máximo :max caracteres',
            ]
        );

        // buscar o user id

        $id = session('user.id');

        //criar uma nova nota
        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        return redirect()->route('home');
    }

    public function editNote($id) {

        $id = Operations::decryptId($id);

        if($id === null) {
            return redirect()->route('home');
        }

        $note = Note::find($id);

        return view('edit_note', ['note' => $note]);
    }

    public function editNoteSubmit(Request $request) {
        //validar o form
        $request->validate(
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000',
            ],
            // mensagem de erros
            [
                'text_title.required' => 'O titulo é obrigatório',
                'text_title.min' => 'A titulo deve ter pelo menos :min caracteres',
                'text_title.max' => 'A titulo deve ter no máximo :max caracteres',
                'text_note.required' => 'A nota é obrigatório',
                'text_note.min' => 'A nota deve ter pelo menos :min caracteres',
                'text_note.max' => 'A nota deve ter no máximo :max caracteres',
            ]
        );

        if($request->note_id === null) {
            return redirect()->route('home');
        }

        $id = Operations::decryptId(value: $request->note_id);
        if($id === null) {
            return redirect()->route('home');
        }

        $note = Note::find(id: $id);

        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        return redirect()->route('home');
    }
   
    public function deletNote($id) {

       $id = Operations::decryptId($id);    

       if($id === null) {
        return redirect()->route('home');
        }

       //carregar a nota
       $note = Note::find($id);

       //show delete note confirmation
       return view('delete_note', ['note' => $note]);
    }

    public function deletNoteConfirm($id) {
        //chacar se o id e encriptado
        $id = Operations::decryptId($id);

        // carregar a nota
        $note = Note::find(id: $id);

        if($id === null) {
            return redirect()->route('home');
        }
        
        // 3. atualizar delete (propriedade no model)
        $note->delete();


        return redirect()->route('home');
    }
}
