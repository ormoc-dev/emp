<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EventController;
use App\Http\Controllers\showEventsController;
use App\Http\Controllers\ContestantController;
use App\Http\Controllers\EventJudgeController;
use App\Http\Controllers\JudgeController;
use App\Http\Controllers\CrteriaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ShowScore_in_admin;
use App\Http\Controllers\ST_or_PD;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\searchEvents;
use App\Models\Criteria;
use App\Http\Controllers\JudgeApprovalController;
use App\Http\Controllers\User_dashboard;
use App\Http\Controllers\UsersVoteController;
use App\Http\Controllers\MinorAwardController;
use App\Http\Controllers\JudgeScoresController;
use App\Http\Controllers\MinorAwardSettingController;
use App\Http\Controllers\SupperAdminController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SupperAdminAudienceController;
use App\Http\Controllers\SupperAdminForgotPasswordController;
use App\Http\Controllers\SupperAdminTabulatorsController;
use App\Http\Controllers\SupperAdminMessageController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\SupperAdminInformationController;
use App\Http\Controllers\SupperAdminMyProfileController;
use App\Http\Controllers\WelcomeBackgroundController;
use App\Http\Controllers\EventHighlightController;
use App\Http\Controllers\VideoHighlightController;
use App\Http\Controllers\PaypalIntegrationController;
use App\Http\Controllers\TimeScheduleController;
use App\Http\Controllers\VotingCategoryController;
use App\Http\Controllers\LiveLinkController;
use App\Http\Controllers\PaypalTransactionController;

Route::get('/', [WelcomeBackgroundController::class, 'Show_to_welcome_page'])->name('welcome');

Route::get('/contact-us', function () {
    return view('contact_us');
})->name('contact_us.admin');

// ... existing code ...
Route::get('/event', [App\Http\Controllers\ServiceController::class, 'index'])->name('events');


Auth::routes();
Route::get('/login/start', function () {
    return view('auth.login');
})->middleware('redirectIfAuthenticated');

Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

// Welcome Background Routes - Protected by auth and admin middleware
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/settings/welcome-background', [WelcomeBackgroundController::class, 'edit'])
        ->name('welcome-background.edit');

    Route::post('/admin/settings/welcome-background', [WelcomeBackgroundController::class, 'update'])
        ->name('welcome-background.update');
});

//⁡⁣⁣⁢ROUTE FOR USER OR AUD SECURED URL :)⁡
Route::middleware(['user'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'users_index'])->name('users_home');
    //get contestant rankings
    Route::get('/api/events/{event}/rankings', [UsersVoteController::class, 'getContestantRankings'])->name('contestant-rankings');
    //profilef
    Route::get('/profile', [User_dashboard::class, 'profile'])->name('profile');
    Route::get('/user/{id}/edit', [UsersVoteController::class, 'edit'])->name('user.edit');
    Route::get('/users/{id}/edit', [UsersController::class, 'edit'])->name('user.edits');
    Route::put('/user/{id}', [UsersVoteController::class, 'update'])->name('user.update');

    //pricing_vote
    Route::get('/pricing_vote', [User_dashboard::class, 'pricing_vote'])->name('pricing_vote');
    Route::get('/pricing_vote/pay', [PaymentController::class, 'pricing_vote_pay'])->name('pricing_vote_pay');
    Route::get('/pricing_vote/pay/success', [PaymentController::class, 'pricing_vote_pay_success'])->name('pricing_vote_pay_success');
    Route::get('/test-payment-success', [PaymentController::class, 'test_payment_success'])->name('test.payment.success');
    //view the contestants in user dash
    Route::get('/event/{id}/contestants', [User_dashboard::class, 'showContestants_user'])->name('event.contestants');
    Route::post('/vote/{contestantId}', [UsersVoteController::class, 'vote'])->name('vote');
    Route::post('/comments/store', [UsersVoteController::class, 'store_comment'])->name('comments.store');
    Route::delete('/comments/{comment}', [UsersVoteController::class, 'destroy_comment'])->name('comments.destroy');
    //paypal integration
    Route::post('/paypal_integration', [PaypalIntegrationController::class, 'paypal_integration'])->name('paypal_integration');
    Route::get('/paypal_integration/success', [PaypalIntegrationController::class, 'paypal_integration_success'])->name('paypal_integration_success');
    Route::get('/paypal_integration/cancel', [PaypalIntegrationController::class, 'paypal_integration_cancel'])->name('paypal_integration_cancel');

    //history

    // routes/web.php
    Route::get('/history', [User_dashboard::class, 'users_history'])->name('user.history');


    Route::get('/events/{event}/live-link', function ($eventId) {
        $liveLink = \App\Models\LiveLink::where('event_id', $eventId)->first();

        if (!$liveLink || !$liveLink->fb_embed_link) {
            return response()->json([
                'success' => false,
                'message' => 'No live stream available',
                'fb_embed_link' => null
            ]);
        }

        return response()->json([
            'success' => true,
            'fb_embed_link' => $liveLink->fb_embed_link
        ]);
    });
});

//⁡⁢⁣⁢⁡⁣⁣⁢ROUTE FOR ADMIN SECURED URL :)⁡
Route::middleware(['admin'])->group(function () {
    //ADMIN HOME
    Route::get('/admin/home', [HomeController::class, 'admin_index'])->name('admin_home');
    Route::get('/events', [HomeController::class, 'getEvents']);

    //VOTING CATEGORIES
    //ADD EVENTS
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events/create/store', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::post('/events/{id}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');
    //ASSIGN JUDGE
    Route::get('/register_judge.com', [EventJudgeController::class, 'register_judge'])->name('register_judge');
    Route::put('/judges/{id}', [JudgeController::class, 'update'])->name('judges.update');
    Route::delete('/judges/{id}', [JudgeController::class, 'deleteJudge'])->name('delete_judge');
    Route::post('/event_judge', [EventJudgeController::class, 'store_judge_event'])->name('event_judge.store');
    Route::delete('/event-judges/multiple-destroy', [EventJudgeController::class, 'multipleDestroy'])->name('event-judges.multiple-destroy');
    Route::delete('/event-judges/{id}', [EventJudgeController::class, 'destroy'])->name('event-judges.destroy');
    Route::get('/judges/available', [EventJudgeController::class, 'getAvailableJudges'])->name('judges.available');
    Route::post('/register-judge', [JudgeController::class, 'store_judge'])->name('register_judge.store');
    Route::delete('/judges/{id}', [JudgeController::class, 'deleteJudge'])->name('delete_judge');
    //LIST OF THE EVENTS IN CONTESTANT ADD
    Route::get('/list/events/Contestants', [showEventsController::class, 'show_event_in_Contestant'])->name('select.event');
    //ADD CONTESTANTS
    Route::get('/events/{id}/add-contestant', [ContestantController::class, 'create'])->name('add.contestant');
    Route::post('/contestants/store', [ContestantController::class, 'store'])->name('store.contestant');
    Route::delete('/contestants/{id}', [ContestantController::class, 'destroy'])->name('contestants.destroy');
    Route::get('/events/{eventId}/contestants', [ContestantController::class, 'showContestants'])->name('show.contestants');
    Route::get('/contestants/{id}/edit', [ContestantController::class, 'edit'])->name('contestants.edit');
    Route::put('/contestants/{id}', [ContestantController::class, 'update'])->name('contestants.update');
    //ADD CRITERIA
    Route::get('/list/events/Criteria', [showEventsController::class, 'show_event_in_criteria'])->name('selectS.event');
    Route::get('/events/{id}/add-Criteria', [CrteriaController::class, 'create'])->name('rounds.create');
    Route::post('/rounds/update-description',  [CrteriaController::class, 'updateDescription'])->name('rounds.updateDescription');
    Route::post('/rounds/add-criteria',  [CrteriaController::class, 'addcriteria'])->name('rounds.add-criteria');
    Route::delete('/criteria/{criterion}', [CrteriaController::class, 'destroy'])->name('criteria.destroy');
    Route::get('/events/{eventId}/proceed-next-round', [ScoreController::class, 'proceedToNextRound'])->name('proceed_next_round');

    Route::post('/criteria/{criteria}/toggle-visibility', [CrteriaController::class, 'toggleVisibility'])->name('criteria.toggle-visibility');
    Route::post('/criteria/{criteria}/hidden-judges', [CrteriaController::class, 'setHiddenJudges'])->name('criteria.hidden-judges');
    // ADD TIME FOR CRITERIA 
    Route::post('/events/{event}/schedule', [TimeScheduleController::class, 'store'])->name('schedule.store');
    Route::put('/events/{event}/schedule', [TimeScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('/events/{event}/schedule', [TimeScheduleController::class, 'destroy'])->name('schedule.destroy');
    //VOTING CATEGORIES
    Route::prefix('events/{event}/voting-categories')->group(function () {
        Route::get('/', [VotingCategoryController::class, 'getEventCategories'])->name('voting-categories.index');
        Route::post('/', [VotingCategoryController::class, 'store'])->name('voting-categories.store');
        Route::delete('/{category}', [VotingCategoryController::class, 'destroy'])->name('voting-categories.destroy');
        Route::put('/{category}/toggle-status', [VotingCategoryController::class, 'toggleStatus'])->name('voting-categories.toggle-status');
        Route::put('/settings', [VotingCategoryController::class, 'updateSettings'])->name('voting-categories.settings.update');
    });
    //live link
    Route::post('/events/{event}/live-link', [LiveLinkController::class, 'store'])->name('live-link.store');
    Route::delete('/events/{event}/live-link', [LiveLinkController::class, 'destroy'])->name('live-link.destroy');
    // Committee scoring routes
    Route::post('/committee/scores', [CommitteeController::class, 'storeScores'])->name('committee.scores.store');
    Route::get('/committee/scores', [CommitteeController::class, 'getScores'])->name('committee.scores.get');
    Route::put('/committee/scores', [CommitteeController::class, 'updateScores'])->name('committee.scores.update');


    //STARTED AND PENDING START BUTTON
    Route::get('/start/or/pending', [ST_or_PD::class, 'SP'])->name('events.Start');
    Route::post('events/{id}/toggle', [ST_or_PD::class, 'toggleStatusSP'])->name('events.toggle');
    //SCORE RESULTS VIEW FOR ADMIN
    Route::get('/showResults', [ShowScore_in_admin::class, 'showResults'])->name('events.showResultsAdmin');
    Route::get('print_pdf/{round}/{tableType}/{criterionId?}', [ShowScore_in_admin::class, 'print_pdf'])->name('print_pdf');
    Route::post('/print-table', [ShowScore_in_admin::class, 'printTable'])->name('print.table');

    //
    Route::post('/events/{event}/calculate-combined-scores', [ShowScore_in_admin::class, 'calculateCombinedScores'])
        ->name('events.calculate_combined_scores');
    Route::get('/admin/events/{event}/print-scores', [ShowScore_in_admin::class, 'printScores'])
        ->name('admin.events.print-scores');
    //SCORES VIEW FOR ADMIN
    Route::get('/events/{event}/results', [ShowScore_in_admin::class, 'showEventResults'])->name('events.showEventResults');
    Route::get('/events/{event}/user_vote', [ShowScore_in_admin::class, 'Uservote_results'])->name('events.user_vote');
    Route::get('/events/{event}/judge_scores', [ShowScore_in_admin::class, 'showJudgeScores'])->name('events.judge_scores');
    Route::get('/events/{event}/user_vote', [ShowScore_in_admin::class, 'showUserVotes'])->name('events.user_vote');
    Route::get('/events/{event}/overall_scores', [ShowScore_in_admin::class, 'showOverallScores'])->name('events.overall_scores');
    //NAKALIMOT KO ANI NGA ROUTS YAWA
    Route::post('/events/{event}/update-status', [ShowScore_in_admin::class, 'updateEventStatus'])->name('update.event.status');
    Route::get('/events/{event}/check-status', [ShowScore_in_admin::class, 'checkEventStatus'])->name('check.event.status');
    //TIE_APROVAL
    Route::get('/events/{event}/approval', [JudgeApprovalController::class, 'approval'])->name('approval');
    Route::post('/judge-approvals', [JudgeApprovalController::class, 'store'])->name('judge-approvals.store');
    //USERS SEE to admin
    Route::get('/users', [UsersController::class, 'showUsersTable'])->name('showUsersTable');
    Route::post('/users', [UsersController::class, 'store'])->name('users.store');
   
    Route::put('/users/{id}', [UsersController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UsersController::class, 'delete'])->name('user.destroy');
    //Settings in admin
    Route::get('/profile_settings', [AdminSettingsController::class, 'profile_settings'])->name('profile_settings');
    Route::post('/admin/profile/update', [AdminSettingsController::class, 'update_profile'])->name('admin.profile.update');
    Route::post('/admin/profile/change_password', [AdminSettingsController::class, 'change_password'])->name('admin.profile.change_password');
});

//⁡⁣⁣⁢ROUTE FOR JUDGES SECURED URL :)⁡
Route::middleware(['judges'])->group(function () {
    //JUDGE HOMEPAGE
    Route::get('/judge/home', [HomeController::class, 'judges_index'])->name('judges_home');
    //LIST OF EVENTS THAT ASSIGN I JEACH JUDGES
    Route::get('/list/events', [JudgeController::class, 'show_events_to_judges'])->name('select.event_in_judges');
    //ROUTES FOR HANDLING SCORE RELTED ACTIONS
    Route::get('/scores/create/{contestantId}/{roundId}', [ScoreController::class, 'create'])->name('scores.create');
    Route::post('/scores/store', [ScoreController::class, 'store'])->name('scores.store');
    Route::get('/events/{eventId}/final-scores', [ScoreController::class, 'showFinalScores'])->name('scores.final');
    Route::get('judge-dashboard/rate/{eventId}/{roundId}}', [ScoreController::class, 'show_contestants_to_events'])->name("view_contestants.event");
    Route::get('judge-dashboard/rate/minor-award/{eventId}', [ScoreController::class, 'showMinorAward'])->name('view_minor_award');
    Route::get('/events/{eventId}/rate-form', [ScoreController::class, 'showRateForm'])->name('rate_form');
    Route::post('/submit-rates', [ScoreController::class, 'submitRates'])->name('submit_rates');
    Route::get('/events/{eventId}/success', [ScoreController::class, 'showSuccessPage'])->name('successPage');
    Route::get('rate/{eventId}/{roundId}', [ScoreController::class, 'showRatePage'])->name('rate_contestants');
    Route::get('/next_round/{eventId}', [ScoreController::class, 'nextRound'])->name('nextRound');
    Route::get('/voting_success/{eventId}', [ScoreController::class, 'votingSuccess'])->name('voting_success');
    Route::get('/event/{eventId}/done_vote', [ScoreController::class, 'doneVote'])->name('done_vote');
});

//⁡⁣⁣⁡⁣⁣⁢ROUTE FOR SUPER ADMIN SECURED URL :)⁡
Route::middleware(['Sadmin'])->group(function () {
    Route::get('/SupAdmin/home', [SupperAdminController::class, 'Sadmin_index'])->name('Sadmin_home');
    Route::get('/api/feedbacks', [SupperAdminController::class, 'getFeedbacks'])->name('api.feedbacks');


    //MESSAGE
    Route::get('/Messages', [SupperAdminMessageController::class, 'index_message'])->name('supper.admin.messages');
    Route::delete('/feedback/{id}', [SupperAdminMessageController::class, 'destroy'])->name('feedback.destroy');
    Route::post('/feedback/delete-multiple', [SupperAdminMessageController::class, 'deleteMultiple'])->name('feedback.delete-multiple');

    //⁡⁣⁣⁢Authentication⁡
    //my Profile
    Route::get('/MyProfile', [SupperAdminMyProfileController::class, 'index_MyProfile'])->name('MyProfile');
    Route::post('/MyProfile/update', [SupperAdminMyProfileController::class, 'update_profile'])->name('Sadmin.profile.update');
    Route::post('/MyProfile/change_password', [SupperAdminMyProfileController::class, 'change_password'])->name('Sadmin.profile.change_password');
    //audience 
    Route::get('/audience', [SupperAdminAudienceController::class, 'index_audience'])->name('audience');
    Route::post('/audience', [SupperAdminAudienceController::class, 'store'])->name('audience.store');
    Route::delete('/audience/{id}', [SupperAdminAudienceController::class, 'destroy'])->name('audience.destroy');
    Route::get('/audience/{id}/edit', [SupperAdminAudienceController::class, 'edit'])->name('audience.edit');
    Route::put('/audience/{id}', [SupperAdminAudienceController::class, 'update'])->name('audience.update');
    //Tabulators
    Route::get('/Tabulators', [SupperAdminTabulatorsController::class, 'index_Tabulators'])->name('Tabulators');
    Route::post('/Tabulators', [SupperAdminTabulatorsController::class, 'store'])->name('Tabulators.store');
    Route::delete('/Tabulators/{id}', [SupperAdminTabulatorsController::class, 'destroy'])->name('Tabulators.destroy');
    Route::get('/tabulators/{id}/edit', [SupperAdminTabulatorsController::class, 'edit'])->name('tabulators.edit');
    Route::put('/tabulators/{id}', [SupperAdminTabulatorsController::class, 'update'])->name('tabulators.update');
    // Forgot Password routes
    Route::get('/ForgotPassword', [SupperAdminForgotPasswordController::class, 'index_ForgotPassword'])->name('ForgotPassword');
    Route::post('/reset-password/{userId}/{userType}', [SupperAdminForgotPasswordController::class, 'resetPassword'])->name('reset.password.action');


    //SALES
    Route::get('/transactions', [PaypalTransactionController::class, 'index'])
        ->middleware(['auth'])
        ->name('transactions.index');

    //SETTINGS PAGES

    Route::get('/settings', [WelcomeBackgroundController::class, 'settings'])->name('settings');
    Route::post('/admin/settings/welcome-background', [WelcomeBackgroundController::class, 'update'])
        ->name('welcome-background.update');




    // Additional routes for ordering and activation
    Route::post('/event_highlights/update-order', [EventHighlightController::class, 'updateOrder'])
        ->name('event_highlights.update-order');
    Route::post('/event_highlights/{highlight}/toggle-active', [EventHighlightController::class, 'toggleActive'])
        ->name('event_highlights.toggle-active');

    //VIDEO HIGHLIGHTS
    Route::get('/video_highlights', [VideoHighlightController::class, 'index'])->name('video-highlights.index');
    Route::post('/video_highlights', [VideoHighlightController::class, 'store'])->name('video-highlights.store');
    Route::get('/video_highlights/{id}/edit', [VideoHighlightController::class, 'edit'])->name('video-highlights.edit');
    Route::put('/video_highlights/{id}', [VideoHighlightController::class, 'update'])->name('video-highlights.update');
    Route::delete('/video_highlights/{id}', [VideoHighlightController::class, 'destroy'])->name('video-highlights.destroy');


    // Supper Admin Information Routes for docs
    Route::get('/documents', [SupperAdminInformationController::class, 'docs_index'])->name('docs_index');
    Route::post('/documents/store', [SupperAdminInformationController::class, 'docs_store'])->name('docs_store');
    Route::put('/documents/{id}', [SupperAdminInformationController::class, 'docs_update'])->name('docs_update');
    Route::delete('/documents/{id}', [SupperAdminInformationController::class, 'docs_destroy'])->name('docs_delete');
});






























//NEW ROUT FOR HANDLING RATES
Route::get('/events/{eventId}/minor-awards', [JudgeScoresController::class, 'showMinorAwards'])->name('minor-awards.show');
//Minor awards route
Route::post('/store/minor_awards/{event}', [MinorAwardController::class, 'store_minor_awards'])->name('store_minor_awards');
Route::delete('/minor-awards/{id}', [MinorAwardController::class, 'destroy'])->name('delete_minor_award');
Route::post('/event/{eventId}/settings', [MinorAwardSettingController::class, 'updateTopContestants'])->name('minor_awards.update_top_contestants');
// Routes for viewing rates and contestants
Route::get('/viewRate', [ScoreController::class, 'viewRate'])->name('viewRate');
Route::get('/determine_top_contestants/{roundId}', [ScoreController::class, 'determineTopContestants'])->name('determine_top_contestants');
//event status





//select events for judge
Route::get('/list/events/judge', [showEventsController::class, 'show_event_in_judge'])->name('select.event_for_judge');
