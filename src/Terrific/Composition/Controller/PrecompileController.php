<?php

namespace Terrific\Composition\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Process\ProcessBuilder;

class PrecompileController extends Controller
{
    /**
     * @Route("/api/precompile/text-x-less", name="precompile_less")
     * @Method({"POST"})
     */
    public function lessAction(Request $request)
    {
        static $format = <<<'EOF'
var less = require('less');
var sys  = require(process.binding('natives').util ? 'util' : 'sys');

new(less.Parser)(%s).parse(%s, function(e, tree) {
    if (e) {
        less.writeError(e);
        process.exit(2);
    }

    try {
        sys.print(tree.toCSS(%s));
    } catch (e) {
        less.writeError(e);
        process.exit(3);
    }
});

EOF;

        $node = '/usr/local/bin/node';
        $nodePaths = array('/usr/local/lib/node', '/usr/local/lib/node_modules');

        $parserOptions = array();
        $treeOptions = array();
        $input = tempnam(sys_get_temp_dir(), 'terrificio_less');

        file_put_contents($input, sprintf($format,
            json_encode($parserOptions),
            json_encode($request->getContent()),
            json_encode($treeOptions)
        ));

        $builder = new ProcessBuilder(array($node, $input));
        $builder->inheritEnvironmentVariables();
        $builder->setEnv('NODE_PATH', implode(':', $nodePaths));
        $builder->setTimeout(3600);

        $process = $builder->getProcess();
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        return new Response($process->getOutput());
    }
}
