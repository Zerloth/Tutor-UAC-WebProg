<?php

namespace App\Http\Controllers;

use App\Events\TictactoeTurn;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TictactoeController extends Controller
{
    public function index(Room $room)
    {
        $user = Auth::user();
        if ($room->user1_id == $user->id || $room->user2_id == $user->id) {
            $symbol = $room->user1_id == $user->id ? 'x' : 'o';
            return view("tictactoe", ['symbol' => $symbol, "dating_code" => $user->dating_code]);
        } else {
            return redirect()->route('home');
        }
    }

    public function turn(Request $request)
    {
        event(new TictactoeTurn($request->room, $request->cell, $request->symbol));

        return response()->json(["success" => $request->all()]);
    }
}
