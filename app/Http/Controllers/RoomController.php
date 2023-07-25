<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function home()
    {
        $user = Auth::user();

        if ($user->role == "admin") {
            return redirect()->route("admin.home");
        }

        $partner_id = $user->gender == "male" ? substr_replace($user->id, "2", -1) : substr_replace($user->id, "1", -1);
        $partner = User::find($partner_id);
        if ($partner) {
            return redirect()->route("partner", ["room" => substr($partner_id, 0, 6)]);
        } else {
            $room = Room::whereNull('user2_id')
                ->join('users', 'users.id', '=', 'rooms.user1_id')
                ->where('users.gender', '<>', $user->gender)
                ->select('rooms.id')
                ->inRandomOrder()
                ->first();

            if (!$room) {
                $room = Room::create([
                    'user1_id' => $user->id,
                ]);
            } else {
                $room->user2_id = $user->id;
                $room->save();
            }

            return redirect()->route('tictactoe', ['room' => $room->id]);
        }
    }
}
