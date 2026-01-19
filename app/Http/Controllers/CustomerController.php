<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Review;
use App\Models\Address;
use App\Models\Wallet;
use App\Models\Message;
use App\Models\User;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('customer');
    }

    // Dashboard Overview
    public function dashboard()
    {
        $user = Auth::user();
        $totalOrders = Order::where('customer_id', $user->id)->count();
        $pendingOrders = Order::where('customer_id', $user->id)
                            ->where('status', 'pending')
                            ->count();
        $totalSpent = Order::where('customer_id', $user->id)
                          ->where('status', 'delivered')
                          ->sum('total_amount');
        $wishlistCount = Wishlist::where('user_id', $user->id)->count();
        
        $recentOrders = Order::where('customer_id', $user->id)
                            ->with('seller')
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        $recentActivity = $this->getRecentActivity($user->id);

        return view('customer.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'totalSpent',
            'wishlistCount',
            'recentOrders',
            'recentActivity'
        ));
    }

    // Orders Management
    public function orders(Request $request)
    {
        $user = Auth::user();
        $status = $request->get('status');
        
        $orders = Order::where('customer_id', $user->id)
                      ->with('seller', 'orderItems.product')
                      ->when($status, function($query, $status) {
                          return $query->where('status', $status);
                      })
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);

        return view('customer.orders', compact('orders', 'status'));
    }

    public function orderDetails($id)
    {
        $order = Order::where('customer_id', Auth::id())
                     ->with('seller', 'orderItems.product', 'shippingAddress')
                     ->findOrFail($id);

        return view('customer.order-details', compact('order'));
    }

    public function trackOrder($id)
    {
        $order = Order::where('customer_id', Auth::id())->findOrFail($id);
        
        // Get tracking information
        $tracking = [
            'status' => $order->status,
            'estimated_delivery' => $order->estimated_delivery,
            'tracking_number' => $order->tracking_number,
            'carrier' => $order->carrier,
            'updates' => json_decode($order->tracking_updates, true) ?? []
        ];

        return view('customer.track-order', compact('order', 'tracking'));
    }

    // Wallet Management
    public function wallet()
    {
        $user = Auth::user();
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $user->id],
            ['balance' => 0]
        );

        $transactions = $wallet->transactions()
                              ->orderBy('created_at', 'desc')
                              ->paginate(10);

        return view('customer.wallet', compact('wallet', 'transactions'));
    }

    public function addFunds(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10|max:10000',
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer'
        ]);

        $user = Auth::user();
        $wallet = Wallet::where('user_id', $user->id)->firstOrFail();

        // Process payment
        // This is where you'd integrate with a payment gateway
        $transaction = $wallet->transactions()->create([
            'type' => 'deposit',
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'reference' => 'DEP_' . time() . '_' . rand(1000, 9999)
        ]);

        return redirect()->route('customer.wallet')
                         ->with('success', 'Funds added successfully!');
    }

    public function requestRefund(Request $request, $orderId)
    {
        $request->validate([
            'reason' => 'required|string|min:10|max:500'
        ]);

        $order = Order::where('customer_id', Auth::id())
                     ->where('id', $orderId)
                     ->firstOrFail();

        if ($order->status !== 'delivered') {
            return back()->with('error', 'Only delivered orders can be refunded.');
        }

        // Create refund request
        $refund = $order->refunds()->create([
            'reason' => $request->reason,
            'amount' => $order->total_amount,
            'status' => 'pending'
        ]);

        return redirect()->route('customer.orders')
                         ->with('success', 'Refund request submitted successfully!');
    }

    // Profile Management
    public function profile()
    {
        $user = Auth::user();
        return view('customer.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date'
        ]);

        $user->update($request->only(['name', 'email', 'phone', 'date_of_birth']));

        return redirect()->route('customer.profile')
                         ->with('success', 'Profile updated successfully!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed'
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('customer.profile')
                         ->with('success', 'Password changed successfully!');
    }

    // Address Management
    public function addresses()
    {
        $user = Auth::user();
        $addresses = $user->addresses()->orderBy('is_default', 'desc')->get();
        
        return view('customer.addresses', compact('addresses'));
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'type' => 'required|in:home,work,other',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'is_default' => 'boolean'
        ]);

        $user = Auth::user();

        // If setting as default, remove default from other addresses
        if ($request->is_default) {
            $user->addresses()->update(['is_default' => false]);
        }

        $user->addresses()->create($request->all());

        return redirect()->route('customer.addresses')
                         ->with('success', 'Address added successfully!');
    }

    public function updateAddress(Request $request, $id)
    {
        $address = Auth::user()->addresses()->findOrFail($id);
        
        $request->validate([
            'type' => 'required|in:home,work,other',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'is_default' => 'boolean'
        ]);

        // If setting as default, remove default from other addresses
        if ($request->is_default) {
            Auth::user()->addresses()->where('id', '!=', $id)->update(['is_default' => false]);
        }

        $address->update($request->all());

        return redirect()->route('customer.addresses')
                         ->with('success', 'Address updated successfully!');
    }

    // Messages/Chat
    public function messages()
    {
        $user = Auth::user();
        
        // Get all conversations
        $conversations = Message::where('sender_id', $user->id)
                               ->orWhere('receiver_id', $user->id)
                               ->with('sender', 'receiver')
                               ->latest()
                               ->get()
                               ->groupBy(function($message) use ($user) {
                                   return $message->sender_id == $user->id 
                                       ? $message->receiver_id 
                                       : $message->sender_id;
                               });

        return view('customer.messages', compact('conversations'));
    }

    public function getMessages($userId)
    {
        $user = Auth::user();
        
        $messages = Message::where(function($query) use ($user, $userId) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', $userId);
        })->orWhere(function($query) use ($user, $userId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', $user->id);
        })->with('sender', 'receiver')
          ->orderBy('created_at', 'asc')
          ->get();

        // Mark messages as read
        Message::where('sender_id', $userId)
               ->where('receiver_id', $user->id)
               ->whereNull('read_at')
               ->update(['read_at' => now()]);

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000'
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        // Broadcast event for real-time chat
        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }

    // Wishlist Management
    public function wishlist()
    {
        $user = Auth::user();
        $wishlistItems = $user->wishlist()->with('product')->paginate(12);

        return view('customer.wishlist', compact('wishlistItems'));
    }

    public function addToWishlist(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $user = Auth::user();
        
        // Check if already in wishlist
        $exists = Wishlist::where('user_id', $user->id)
                         ->where('product_id', $request->product_id)
                         ->exists();

        if (!$exists) {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id
            ]);
        }

        return redirect()->back()->with('success', 'Added to wishlist!');
    }

    public function removeFromWishlist($productId)
    {
        Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->delete();

        return redirect()->back()->with('success', 'Removed from wishlist!');
    }

    public function clearWishlist()
    {
        Wishlist::where('user_id', Auth::id())->delete();

        return redirect()->route('customer.wishlist')
                         ->with('success', 'Wishlist cleared!');
    }

    // Reviews Management
    public function reviews()
    {
        $user = Auth::user();
        $reviews = $user->reviews()->with('product')->paginate(10);

        return view('customer.reviews', compact('reviews'));
    }

    public function submitReview(Request $request)
    {
        $request->validate([
            'order_item_id' => 'required|exists:order_items,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|min:10|max:1000'
        ]);

        $user = Auth::user();
        
        // Check if user purchased this product
        $orderItem = OrderItem::whereHas('order', function($query) use ($user) {
            $query->where('customer_id', $user->id);
        })->findOrFail($request->order_item_id);

        // Check if already reviewed
        $existingReview = Review::where('user_id', $user->id)
                               ->where('product_id', $orderItem->product_id)
                               ->first();

        if ($existingReview) {
            $existingReview->update([
                'rating' => $request->rating,
                'review' => $request->review
            ]);
        } else {
            Review::create([
                'user_id' => $user->id,
                'product_id' => $orderItem->product_id,
                'order_item_id' => $request->order_item_id,
                'rating' => $request->rating,
                'review' => $request->review,
                'status' => 'approved'
            ]);
        }

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }

    public function updateReview(Request $request, $id)
    {
        $review = Auth::user()->reviews()->findOrFail($id);
        
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|min:10|max:1000'
        ]);

        $review->update($request->only(['rating', 'review']));

        return redirect()->route('customer.reviews')
                         ->with('success', 'Review updated successfully!');
    }

    public function deleteReview($id)
    {
        $review = Auth::user()->reviews()->findOrFail($id);
        $review->delete();

        return redirect()->route('customer.reviews')
                         ->with('success', 'Review deleted successfully!');
    }

    // Returns & Refunds
    public function returns()
    {
        $user = Auth::user();
        $returns = $user->orders()
                       ->whereHas('refunds')
                       ->with('refunds')
                       ->paginate(10);

        return view('customer.returns', compact('returns'));
    }

    public function requestReturn(Request $request, $orderId)
    {
        $request->validate([
            'order_item_ids' => 'required|array',
            'reason' => 'required|string|min:10|max:500',
            'description' => 'required|string|min:20|max:1000'
        ]);

        $order = Order::where('customer_id', Auth::id())
                     ->findOrFail($orderId);

        // Create return request
        $returnRequest = $order->returns()->create([
            'reason' => $request->reason,
            'description' => $request->description,
            'status' => 'pending'
        ]);

        // Attach items to return
        $returnRequest->items()->createMany(
            collect($request->order_item_ids)->map(function($itemId) {
                return ['order_item_id' => $itemId];
            })->toArray()
        );

        return redirect()->route('customer.returns')
                         ->with('success', 'Return request submitted successfully!');
    }

    // Helper Methods
    private function getRecentActivity($userId)
    {
        $activities = collect();
        
        // Recent orders
        $recentOrders = Order::where('customer_id', $userId)
                            ->with('seller')
                            ->orderBy('created_at', 'desc')
                            ->take(3)
                            ->get();
        
        foreach ($recentOrders as $order) {
            $activities->push([
                'type' => 'order',
                'title' => 'Order #' . $order->order_number . ' placed',
                'description' => 'Order placed with ' . $order->seller->name,
                'time' => $order->created_at->diffForHumans(),
                'icon' => 'shopping-cart',
                'color' => 'primary'
            ]);
        }

        // Recent messages
        $recentMessages = Message::where('receiver_id', $userId)
                                ->whereNull('read_at')
                                ->with('sender')
                                ->orderBy('created_at', 'desc')
                                ->take(2)
                                ->get();
        
        foreach ($recentMessages as $message) {
            $activities->push([
                'type' => 'message',
                'title' => 'New message from ' . $message->sender->name,
                'description' => substr($message->message, 0, 50) . '...',
                'time' => $message->created_at->diffForHumans(),
                'icon' => 'comment',
                'color' => 'secondary'
            ]);
        }

        // Recent reviews
        $recentReviews = Review::where('user_id', $userId)
                              ->with('product')
                              ->orderBy('created_at', 'desc')
                              ->take(2)
                              ->get();
        
        foreach ($recentReviews as $review) {
            $activities->push([
                'type' => 'review',
                'title' => 'Review submitted for ' . $review->product->name,
                'description' => 'Rating: ' . $review->rating . '/5',
                'time' => $review->created_at->diffForHumans(),
                'icon' => 'star',
                'color' => 'success'
            ]);
        }

        return $activities->sortByDesc('time')->take(5);
    }

    // Customer Support
    public function support()
    {
        return view('customer.support');
    }

    public function submitSupportTicket(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'category' => 'required|in:technical,billing,account,other',
            'message' => 'required|string|min:20|max:2000',
            'priority' => 'required|in:low,medium,high'
        ]);

        $user = Auth::user();

        $ticket = $user->supportTickets()->create([
            'subject' => $request->subject,
            'category' => $request->category,
            'message' => $request->message,
            'priority' => $request->priority,
            'status' => 'open'
        ]);

        return redirect()->route('customer.support')
                         ->with('success', 'Support ticket submitted successfully!');
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}