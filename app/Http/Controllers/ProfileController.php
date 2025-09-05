<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Builders\ProfileBuilder;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private function getProfileBuilder(): ProfileBuilder
    {
        return new ProfileBuilder();
    }

    public function show(Request $request): Profile
    {
        $user = $request->user();
        return Profile::where('user_id', $user->id)->get()->first();
    }

    public function update(Request $request): Profile
    {
        $data = $request->all();
        $user = $request->user();
        $data['user'] = $request->user();
        $profile = Profile::where('user_id', $user->id)->first();
        $profile = $this->getProfileBuilder()->withObject($profile)->withDataArray($data)->build();
        $profile->save();

        return $profile;
    }
}
