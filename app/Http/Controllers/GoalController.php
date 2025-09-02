<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Builders\GoalBuilder;
use App\Http\Controllers\Traits\IsCompleted;
use App\Models\Goal;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    use IsCompleted;

    private function getGoalBuilder(): GoalBuilder
    {
        return new GoalBuilder();
    }

    public function all(Request $request)
    {
        $completed = $this->isCompleted();
        $user = $request->user();
        return Goal::where('user_id', $user->id)->where('completed', $completed)->get();
    }

    public function create(Request $request): Goal
    {
        $data = $request->all();
        $data['user'] = $request->user();
        $goal = $this->getGoalBuilder()->withDataArray($data)->build();
        $goal->save();

        return $goal;
    }

    public function show(Goal $goal): Goal
    {
        return $goal;
    }

    public function update(Request $request, Goal $goal): Goal
    {
        $data = $request->all();
        $data['user'] = $request->user();
        $goal = $this->getGoalBuilder()->withObject($goal)->withDataArray($data)->build();
        $goal->save();

        return $goal;
    }

    public function delete(Goal $goal): array
    {
        $goal->delete();
        return ['status' => true];
    }

    public function statusChange(Goal $goal): Goal
    {
        $goal->completed = !$goal->completed;
        $goal->save();

        return $goal;
    }
}
