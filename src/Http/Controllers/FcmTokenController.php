<?php

namespace Elnooronline\Notifications\Http\Controllers;

use Elnooronline\Notifications\Entities\Concerns\HasFcmTokens;
use Elnooronline\Notifications\Entities\FcmToken;
use Elnooronline\Notifications\Http\Requests\FcmTokenRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FcmTokenController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Elnooronline\Notifications\Http\Requests\FcmTokenRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(FcmTokenRequest $request)
    {
        $user = $request->user();

        if (! $user instanceof HasFcmTokens) {
            abort(404, '"elnooronline/elnooronline-notifications" poorly installed.');
        }

        if ($token = $user->getFcmToken($request->input('token'), $request->input('device_name'))) {
            $token->extendExpireAt();

            return response()->json([
                'message' => trans('elnooronline-notifications.messages.already_exists'),
            ]);
        }

        $user->addFcmToken($request->validated());

        return response()->json([
            'message' => trans('elnooronline-notifications.messages.created'),
        ]);
    }

    /**
     * Delete specific token or tokens from storage.
     *
     * @param Request $request
     * @param FcmToken|null $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, FcmToken $token = null)
    {
        if ($token) {
            $token->delete();
        } else {
            $request->user()
                ->activeTokens()
                ->each(function (FcmToken $token) {
                    $token->delete();
                });
        }

        return response()->json([
            'message' => trans('elnooronline-notifications.messages.deleted'),
        ]);
    }
}
