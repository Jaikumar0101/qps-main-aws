<?php

namespace App\Security;

use Illuminate\Http\Request;
use Spatie\Csp\Directive;
use Spatie\Csp\Exceptions\InvalidDirective;
use Spatie\Csp\Exceptions\InvalidValueSet;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policies\Basic;
use Symfony\Component\HttpFoundation\Response;

class ContentPolicy extends Basic
{
    /**
     * @throws InvalidDirective
     * @throws InvalidValueSet
     */

    public function configure()
    {
        parent::configure();

        $nodeUrl = request()->getHost().":".env('APP_NODE_PORT',3000);

        $this->addDirective(Directive::BASE, Keyword::NONE)
            ->addDirective(Directive::CONNECT, [
                Keyword::SELF,
                $nodeUrl,
                "wss://".$nodeUrl
            ])
            ->addDirective(Directive::DEFAULT, Keyword::SELF)
            ->addDirective(Directive::CHILD, Keyword::NONE)
            ->addDirective(Directive::FORM_ACTION,[
                 Keyword::SELF,
            ])
            ->addDirective(Directive::STYLE,[
                 Keyword::SELF,
            ])
            ->addDirective(Directive::STYLE_ELEM,[
                Keyword::UNSAFE_INLINE,
                Keyword::SELF,
            ])
            ->addDirective(Directive::STYLE_ATTR,[
                Keyword::UNSAFE_INLINE,
                Keyword::SELF,
            ])
            ->addDirective(Directive::SCRIPT,[
                Keyword::UNSAFE_EVAL,
                Keyword::SELF
            ])
            ->addDirective(Directive::SCRIPT_ELEM,[
                Keyword::UNSAFE_INLINE,
                Keyword::SELF,
            ])
            ->addDirective(Directive::SCRIPT_ATTR,[
                Keyword::UNSAFE_INLINE,
                Keyword::SELF,
            ])
            ->addDirective(Directive::IMG, [
                 Keyword::SELF,
            ])
            ->addDirective(Directive::MEDIA, [
                 Keyword::SELF,
            ])
            ->addDirective(Directive::OBJECT, Keyword::NONE)
            ->addDirective(Directive::FONT,[
                 Keyword::SELF,
            ]);
    }

    public function shouldBeApplied(Request $request, Response $response): bool
    {
        if (config('app.debug') && ($response->isClientError() || $response->isServerError()))
        {
            return false;
        }

        return parent::shouldBeApplied($request, $response);
    }
}
