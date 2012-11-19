<?php
/*
 * This file is part of the Terrific Composer Bundle.
 *
 * (c) Remo Brunschwiler <remo@terrifically.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Terrific\Composition\Service;

use Symfony\Component\Process\ProcessBuilder;

/**
 * PreCompiler
 */
class PreCompiler
{
    private $node = null;
    private $nodePaths = array();

    public function __construct($node, $nodePaths) {
        $this->node = $node;
        $this->nodePaths = $nodePaths;
    }

    public function precompile($content, $type)
    {
        if ($type === 'text-x-less') {
            $compiled = $this->less($content);
        }

        return $compiled;
    }

    private function less($content)
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

        $parserOptions = array();
        $treeOptions = array();
        $input = tempnam(sys_get_temp_dir(), 'terrificio_less');

        file_put_contents($input, sprintf($format,
            json_encode($parserOptions),
            json_encode($content),
            json_encode($treeOptions)
        ));

        $builder = new ProcessBuilder(array($this->node, $input));
        $builder->inheritEnvironmentVariables();
        $builder->setEnv('NODE_PATH', implode(':', $this->nodePaths));
        $builder->setTimeout(3600);

        $process = $builder->getProcess();
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        return $process->getOutput();
    }
}