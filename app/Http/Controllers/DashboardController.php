<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\StatusEnum;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Function lists all the tasks.
     *
     * @return Response
     */
    public function index(): Response
    {

        $user = auth()->user();
        $totalPendingTasks = Task::query()
            ->where('status', StatusEnum::PENDING)
            ->count();
        $myPendingTasks = Task::query()
            ->where('status', StatusEnum::PENDING)
            ->where('assigned_user_id', $user->id)
            ->count();


        $totalProgressTasks = Task::query()
            ->where('status', StatusEnum::IN_PROGRESS)
            ->count();
        $myProgressTasks = Task::query()
            ->where('status', StatusEnum::IN_PROGRESS)
            ->where('assigned_user_id', $user->id)
            ->count();


        $totalCompletedTasks = Task::query()
            ->where('status', StatusEnum::COMPLETED)
            ->count();
        $myCompletedTasks = Task::query()
            ->where('status', StatusEnum::COMPLETED)
            ->where('assigned_user_id', $user->id)
            ->count();

        $activeTasks = Task::query()
            ->whereIn('status', [StatusEnum::PENDING, StatusEnum::IN_PROGRESS])
            ->where('assigned_user_id', $user->id)
            ->limit(10)
            ->get();
        $activeTasks = TaskResource::collection($activeTasks);

        return inertia(
            'Dashboard',
            compact(
                'totalPendingTasks',
                'myPendingTasks',
                'totalProgressTasks',
                'myProgressTasks',
                'totalCompletedTasks',
                'myCompletedTasks',
                'activeTasks'
            )
        );
    }
}
