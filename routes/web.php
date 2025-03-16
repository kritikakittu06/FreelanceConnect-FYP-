<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FreelancerDashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ClientDashboarController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\clientfreelancerController;
use App\Http\Controllers\ClientFreelancerProfileController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ClientProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\PostProjectController;

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PostProjectController as ControllersPostProjectController;

Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
});
Route::get('/messages', function () {
    return view('messages'); // Return the messages view
})->name('messages.index');

// If you want to handle form submission without a controller
Route::post('/messages', function (Illuminate\Http\Request $request) {
    // Here you can handle the message submission
    // For now, just redirect back with a success message
    return redirect()->route('messages.index')->with('success', 'Message sent successfully!');
})->name('messages.store');

Route::get('/', function () {
    return view('welcome');
});
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');



Route::get('/freelancer/dashboard', [FreelancerDashboardController::class, 'index'])->name('freelancer.dashboard');
Route::get('/client/dashboard', [ClientDashboarController::class, 'index'])->name('client.dashboard');

Route::get('/dashboard', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'freelancer') {
            return redirect()->route('freelancer.dashboard');
        } elseif (Auth::user()->role === 'client') {
            return redirect()->route('client.dashboard');
        }
    }
    return redirect()->route('login'); // Fallback if not authenticated
})->name('dashboard');


Route::post('/login', [AuthController::class, 'login'])->name('login');
// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
// });
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
Route::delete('admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');


Route::middleware('auth')->group(function () {
    Route::get('/client/freelancers', [ClientFreelancerController::class, 'index'])
         ->name('freelancers.index');
});
Route::middleware('auth')->group(function () {
    Route::get('/freelancer/profile/{id}', [ClientFreelancerProfileController::class, 'show'])->name('freelancer.profile');
});






Route::middleware('auth')->group(function () {
    // Freelancer's Chat Interface (Freelancer side)
    Route::get('/freelancer/chat/{otherUserId}', [ChatController::class, 'freelancerChat'])->name('freelancer.chat');

    // You can keep the same routes for fetching messages and sending messages
    Route::get('/chat/fetch/{otherUserId}', [ChatController::class, 'fetchMessages'])->name('chat.fetch');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::delete('/chat/delete/{messageId}', [ChatController::class, 'delete'])->name('chat.delete');
});
Route::post('/{freelancer}/rate', [RatingController::class, 'rateFreelancer'])->name('rate.freelancer');
Route::post('/{freelancer}/review', [RatingController::class, 'reviewFreelancer'])->name('review.freelancer');


// Route for client profile edit
Route::get('/client/profile/edit', [ClientProfileController::class, 'edit'])->name('client.profile.edit');

// Route for client profile update (submit the form)
Route::put('/client/profile/edit', [ClientProfileController::class, 'update'])->name('client.profile.update');

Route::get('/about',[AboutController::class, 'index'])->name('about');

Route::get('/messages', [ChatController::class, 'freelancerChat'])->name('Messages');

Route::middleware('auth')->group(function () {
    // Show chat interface with a specific user (pass the other user ID)
    Route::get('/chat/{otherUserId}', [ChatController::class, 'index'])->name('chat.index');

    // AJAX route to fetch messages (optional, if you want polling)
    Route::get('/chat/fetch/{otherUserId}', [ChatController::class, 'fetchMessages'])->name('chat.fetch');

    // AJAX route to send a new message
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::delete('/chat/delete/{messageId}', [ChatController::class, 'delete'])->name('chat.delete');



});

// Route::get('/dashboard', [FreelancerDashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
// Route::get('/clientdashboard', [ClientDashboarController::class, 'index'])->name('Clientdashboard');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects');

// Route::get('/clients', [ClientController::class, 'index'])->name('clients');
Route::get('/dashboard/clients', [ClientController::class, 'index'])->name('clients.index');
Route::get('/dashboard/clients/create', [ClientController::class, 'create'])->name('clients.create');
Route::post('/dashboard/clients', [ClientController::class, 'store'])->name('clients.store');
Route::get('/dashboard/clients/{client}', [ClientController::class, 'show'])->name('clients.show');
Route::get('/dashboard/clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
Route::put('/dashboard/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
Route::delete('/dashboard/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');

Route::post('/dashboard/clients/{client}/notes', [ClientController::class, 'addNote'])->name('clients.addNote');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::match(['post', 'patch'], '/profile/update-image', [ProfileController::class, 'updateImage'])
    ->name('profile.update-image');


});

Route::middleware(['auth'])->group(function () {
    Route::get('clients/{client}', [ClientController::class, 'show'])->name('clients.show');
    // Route::get('projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::post('clients/{client}/add-note', [NoteController::class, 'store'])->name('clients.addNote');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
});

// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', [FreelancerDashboardController::class, 'index'])->name('dashboard');
//     Route::get('/job-offer/{id}', [JobOfferController::class, 'show'])->name('job.offer');
//     Route::resource('project', ProjectController::class);
//     Route::get('/project/{id}', [ProjectController::class, 'show'])->name('project.view');
// });

Route::middleware('auth')->group(function () {
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('project.store');
    Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');



});

Route::get('paypal', [PaymentController::class, 'index'])->name('payment.index');
Route::get('paypal/payment', [PaymentController::class, 'payment'])->name('paypal.payment');
Route::get('paypal/payment/success', [PaymentController::class, 'paymentSuccess'])->name('paypal.payment.success');
Route::get('paypal/payment/cancel', [PaymentController::class, 'paymentCancel'])->name('paypal.payment/cancel');

Route::post('/post-project', [PostProjectController::class, 'store'])->name('post.project');

require __DIR__.'/auth.php';
