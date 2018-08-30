<?php
/**
 * Console initializer
 * User: moyo
 * Date: 12/12/2017
 * Time: 4:20 PM
 */

namespace Carno\Console;

use Carno\Console\Chips\CMDKit;
use Carno\Container\DI;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

class Initializer
{
    use CMDKit;

    /**
     * @var Application
     */
    private $app = null;

    /**
     * @var Bootstrap
     */
    private $boot = null;

    /**
     * Initializer constructor.
     */
    public function __construct()
    {
        DI::set(Bootstrap::class, $this->boot = DI::object(Bootstrap::class));

        $this->app = new Application;

        $this->app->setCatchExceptions(false);

        $this->addCommand(...$this->provides());
    }

    /**
     * @param string ...$mods
     * @return static
     */
    public function initial(string ...$mods) : self
    {
        $this->boot->kernel(...$mods);
        return $this;
    }

    /**
     * @param string ...$cmds
     * @return static
     */
    public function commands(string ...$cmds) : self
    {
        $this->addCommand(...$cmds);
        return $this;
    }

    /**
     */
    public function start() : void
    {
        try {
            $this->app->run();
        } catch (Throwable $e) {
            $this->failure($e);
        }
    }

    /**
     * @param string ...$classes
     */
    private function addCommand(string ...$classes) : void
    {
        foreach ($classes as $class) {
            $this->app->add(
                $this->setCommandPTS(
                    (new Proxy)->setBootstrap($this->boot)->setCommand($class),
                    $class,
                    ['app', 'name', 'help', 'description']
                )
            );
        }
    }

    /**
     * @return array
     */
    private function provides() : array
    {
        return (defined('CWD') && is_file($cf = CWD . '/commands.php')) ? (array) include $cf : [];
    }

    /**
     * @param Throwable $e
     */
    private function failure(Throwable $e) : void
    {
        $styled = (new SymfonyStyle(new ArgvInput, new ConsoleOutput));
        $styled->title(get_class($e));
        $styled->error($e->getMessage());
        $styled->note(sprintf('%s:%d', $e->getFile(), $e->getLine()));
        $styled->text(['TRACES', $e->getTraceAsString()]);
        exit(1);
    }
}