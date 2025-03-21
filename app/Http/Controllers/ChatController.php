<?php

namespace App\Http\Controllers;


use App\Enums\UserRole;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Events\MessageSent;


class ChatController extends Controller
{
    // Display the chat interface between the authenticated user and a selected user
    public function index($otherUserId)
    {
        $userId = Auth::id();
        // Fetch all messages between the authenticated user and the other user
        $messages = ChatMessage::where(function ($q) use ($userId, $otherUserId) {
            $q->where('sender_id', $userId)
                ->where('receiver_id', $otherUserId);
        })
            ->orWhere(function ($q) use ($userId, $otherUserId) {
                $q->where('sender_id', $otherUserId)
                    ->where('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $otherUser = User::query()->where('role', UserRole::FREELANCER)->where('id',$otherUserId)->firstOrFail();

        return view('chat.index', compact('messages', 'otherUser'));
    }

    // Fetch messages via AJAX (if you want to poll for new messages)
    public function fetchMessages($otherUserId)
    {
        $userId = Auth::id();

        $messages = ChatMessage::where(function ($q) use ($userId, $otherUserId) {
            $q->where('sender_id', $userId)
                ->where('receiver_id', $otherUserId);
        })
            ->orWhere(function ($q) use ($userId, $otherUserId) {
                $q->where('sender_id', $otherUserId)
                    ->where('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }


    public function delete($messageId)
    {
        try {
            $message = ChatMessage::findOrFail($messageId);

            // Check if the user owns this message
            if ($message->sender_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            // Delete associated image if exists
            if ($message->image) {
                Storage::disk('public')->delete($message->image);
            }

            // Delete the message
            $message->delete();

            return response()->json([
                'success' => true,
                'message' => 'Message deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting message'
            ], 500);
        }
    }




    // Send a new message via AJAX
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message'     => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Get the authenticated user's ID
        $senderId = Auth::id();

        // Debugging: Check if the sender ID is being retrieved correctly
        if (!$senderId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: No authenticated user found',
            ], 401);
        }

        // Get receiver ID from request
        $receiverId = $request->receiver_id;

        // Ensure message is not null
        $messageText = $request->message ?? '';

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chat_images', 'public');
        }

        // Save the message
        $chatMessage = ChatMessage::create([
            'sender_id'   => $senderId,
            'receiver_id' => $receiverId,
            'message'     => $messageText,
            'image'       => $imagePath,
        ]);

        // Optionally, broadcast the message for real-time updates here
        // Dispatch the event to broadcast the message
        broadcast(new MessageSent($chatMessage));

        return redirect()->back()->with('success', 'Message sent successfully');
    }

    // app/Http/Controllers/ChatController.php

    public function freelancerChat($otherUserId)
    {
        $userId = Auth::id();

        // Fetch all messages between the authenticated freelancer and the client
        $messages = ChatMessage::where(function ($q) use ($userId, $otherUserId) {
            $q->where('sender_id', $userId)
                ->where('receiver_id', $otherUserId);
        })
            ->orWhere(function ($q) use ($userId, $otherUserId) {
                $q->where('sender_id', $otherUserId)
                    ->where('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $otherUser = User::query()->where('id',$otherUserId)->firstOrFail();

        // Pass the messages and the other user's ID to the freelancer chat view
        return view('chat.freelancer_chat', compact('messages', 'otherUser'));
    }
}
