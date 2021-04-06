<?php


namespace App\Http\Controllers\Api;


use App\Libraries\ResponseStd;
use App\Models\User;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\Http\Controllers\AccessTokenController as ParentAccessTokenController;
use Laravel\Passport\TokenRepository;
use Lcobucci\JWT\Parser as JwtParser;
use League\OAuth2\Server\AuthorizationServer;
use Psr\Http\Message\ServerRequestInterface;

class AccessTokenController extends ParentAccessTokenController
{
    use ValidatesRequests;

    public function __construct(AuthorizationServer $server, TokenRepository $tokens, JwtParser $jwt)
    {
        parent::__construct($server, $tokens, $jwt);
    }

    public function issueToken(ServerRequestInterface $request)
    {
        $body = $request->getParsedBody();
        $response =  parent::issueToken($request);

        $user = User::query()->where('email', $body['username'])->firstOrFail();

        $decoded = json_decode($response->getContent());
        $decoded->user =  $user;
        $response->setContent(json_encode($decoded));
        return $response;
    }
}
