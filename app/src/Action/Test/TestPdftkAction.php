<?php

namespace App\Action\Test;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TestPdftkAction {

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $pdftk = shell_exec('pdftk -version');
        $which = shell_exec('which pdftk');
        $locales = shell_exec('locale -a');
        $env = json_encode($_ENV);

        $result = '<pre>pdftk -version<br><br>'.$pdftk.'</pre>';
        $result .= '<br><pre>locale -a<br><br>'.$locales.'</pre>';
        $result .= '<br><pre>which pdftk<br><br>'.$which.'</pre>';
        $result .= '<br><pre>'.$env.'</pre>';

        $response->getBody()->write($result);
        return $response;
    }

}
