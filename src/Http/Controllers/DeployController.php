<?php

namespace Quepenny\Livewire\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class DeployController extends Controller
{
    /**
     * @throws Exception
     */
    public function __invoke(Request $request)
    {
        $signature = 'sha1='.hash_hmac(
            'sha1',
            $request->getContent(),
            config('app.deploy_secret')
        );

        $invalidSignature = ! hash_equals(
            $signature, $request->header('X-Hub-Signature')
        );

        if ($invalidSignature) {
            throw new Exception('Incorrect Signature');
        }

        $process = new Process(['./deploy.sh'], base_path());

        $process->run(function ($type, $buffer) {
            echo $buffer;
        });
    }
}
