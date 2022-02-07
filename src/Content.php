<?php

namespace ClarkWinkelmann\JWTCookie;

use Dflydev\FigCookies\FigRequestCookies;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Flarum\Frontend\Document;
use Flarum\Settings\SettingsRepositoryInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Utils;
use Illuminate\Contracts\Cache\Repository;
use Psr\Http\Message\ServerRequestInterface;

class Content
{
    protected $settings;
    protected $cache;
    protected $client;

    public function __construct(SettingsRepositoryInterface $settings, Repository $cache, Client $client)
    {
        $this->settings = $settings;
        $this->cache = $cache;
        $this->client = $client;
    }

    public function __invoke(Document $document, ServerRequestInterface $request)
    {
        $cookie = FigRequestCookies::get($request, $this->settings->get('jwt-cookie.cookieName') ?: 'invalid');

        $safeExceptionClass = 'valid';

        $jwt = $cookie->getValue();

        try {
            JWT::decode($jwt, $this->keys());
        } catch (\Exception $exception) {
            $safeExceptionClass = e(get_class($exception) . ': ' . $exception->getMessage());
        }

        $safeProjectId = '<em>Not found</em>';
        $safeUserId = '<em>Not found</em>';

        try {
            $tks = \explode('.', $jwt);
            list($headb64, $bodyb64, $cryptob64) = $tks;
            $payload = JWT::jsonDecode(JWT::urlsafeB64Decode($bodyb64));

            if (isset($payload->aud)) {
                $safeProjectId = e($payload->aud);
            }

            if (isset($payload->sub)) {
                $safeUserId = e($payload->sub);
            }
        } catch (\Exception $exception) {
            // ignore exceptions
        }

        $safeCookieValue = e($jwt) ?: '<em>Empty/Missing</em>';

        $document->head[] = <<<HTML
<h3>JWT test</h3>
<dl>
<dt>Cookie</dt>
<dd>$safeCookieValue</dd>
</dl>
<dl>
<dt>Firebase Project ID</dt>
<dd>$safeProjectId</dd>
</dl>
<dl>
<dt>Firebase User ID</dt>
<dd>$safeUserId</dd>
</dl>
<dl>
<dt>Validity</dt>
<dd>$safeExceptionClass</dd>
</dl>
HTML;
    }

    protected function keys()
    {
        if ($this->settings->get('jwt-cookie.publicKey')) {
            return new Key($this->settings->get('jwt-cookie.publicKey'), $this->settings->get('jwt-cookie.publicKeyAlgorithm'));
        }

        $keys = $this->cache->remember('firebase-keys', 86400, function () {
            // Based on https://firebase.google.com/docs/auth/admin/verify-id-tokens?hl=en#verify_id_tokens_using_a_third-party_jwt_library
            return Utils::jsonDecode($this->client->get('https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com')->getBody()->getContents(), true);
        });

        return array_map(function ($key) {
            return new Key($key, 'RS256');
        }, $keys);
    }
}
