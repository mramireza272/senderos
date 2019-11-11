<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Events\EventUserLog;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login']]);

        $this->event = collect(['app' => 'DIFAlimentos','host' => url()->current(), 'active'=> true, 'remote_ip' => \Request::getClientIp()]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (!$request->has('imei') || trim($request->imei) == '' || is_null($request->imei)) {
            $this->event->put('device_info',$request->has('device_info')?$request->device_info:'');
            $this->event->put('project',$request->has('project')?$request->project:'');
            $this->event->put('imei',$request->imei);
            $this->event->put('latitude',$request->latitude);
            $this->event->put('longitude',$request->longitude);
            $this->event->put('sessionID', [session()->getId()]);
            $this->event->put('user_id', $request->email);
            $this->event->put('email', $request->email);
            $this->event->put('type', 'login');
            $this->event->put('attemp', 'failed');
            $this->event->put('request',$request->except('password'));
            event(new EventUserLog($this->event));

            return response()->json([
                'response' => [
                    'code' => 2,
                    'msg'  => 'Sin autorización'
                ]
            ], 401);
        }

        $claims = [
            'project' => $request->has('project')?$request->project:'',
            'imei'    => $request->imei,
            'plates'  => $request->has('plates')?$request->plates:'SIN PLACAS',

        ];

        if (!$token = auth('api')->claims($claims)->attempt($credentials)) {
            $this->event->put('device_info',$request->has('device_info')?$request->device_info:'');
            $this->event->put('project',$request->has('project')?$request->project:'');
            $this->event->put('imei',$request->imei);
            $this->event->put('latitude',$request->latitude);
            $this->event->put('longitude',$request->longitude);
            $this->event->put('sessionID', [session()->getId()]);
            $this->event->put('user_id', $request->email);
            $this->event->put('email', $request->email);
            $this->event->put('type', 'login');
            $this->event->put('attemp', 'failed');
            $this->event->put('request',$request->except('password'));
            event(new EventUserLog($this->event));

            return response()->json([
                'response' => [
                    'code' => 1,
                    'msg'  => 'Sin autorización'
                ]
            ], 401);
        }

        return $this->respondWithToken($token,$request);
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }
    public function payload()
    {
        return response()->json(auth('api')->payload());
    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Ha salido exitósamente']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }
    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token,$request)
    {
        $this->event->put('device_info',$request->has('device_info')?$request->device_info:'');
        $this->event->put('project',$request->has('project')?$request->project:'');
        $this->event->put('imei',$request->imei);
        $this->event->put('latitude',$request->latitude);
        $this->event->put('longitude',$request->longitude);
        $this->event->put('sessionID', [session()->getId()]);
        $this->event->put('user_id', auth('api')->user()->id);
        $this->event->put('email', $request->email);
        $this->event->put('type', 'login');
        $this->event->put('attemp', 'success');
        $this->event->put('request',$request->except('password'));
        event(new EventUserLog($this->event));

        $payload = auth('api')->payload();

        return response()->json([
            'response' => [
                'code' => 0,
                'msg'  => 'Ok'
            ],
            'data'  => [
                'access_token' => $token,
                'token_type'   => 'bearer',
                'expires_in'   => auth('api')->factory()->getTTL() * 60,
                'user'         => [
                    'name'    => auth('api')->user()->name,
                    'paterno' => auth('api')->user()->paterno,
                    'materno' => auth('api')->user()->materno,
                    'email'   => auth('api')->user()->email,
                    'user_id' => auth('api')->user()->id,
                    'project' => $payload->get('project'),
                ],
            ]
        ], 200);
    }

}