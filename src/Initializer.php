<?php
/**
 * Console initializer
 * User: moyo
 * Date: 12/12/2017
 * Time: 4:20 PM
 */

namespace Carno\Console;

use Carno\Console\Chips\CMDKit;
use Carno\Console\Chips\Dumps;
use Carno\Container\DI;
use Symfony\Component\Console\Application;
use Throwable;

class Initializer
{
    use CMDKit;
    use Dumps;

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

        ($this->app = new Application())
            ->setCatchExceptions(false)
        ;
    }

    /**
     * @return static
     */
    public function components() : self
    {
        foreach (get_defined_constants(true)['user'] ?? [] as $name => $value) {
            if (substr($name, 5, 12) === '_COMPONENTS_') {
                $this->bootstrap(...$value);
            }
        }
        return $this;
    }

    /**
     * @param string ...$mods
     * @return static
     */
    public function bootstrap(string ...$mods) : self
    {
        $this->boot->register(...$mods);
        return $this;
    }

    /**
     * @return static
     */
    public function additions() : self
    {
        $this->addCommand(...$this->provides());
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
            $this->failure($e, 1);
        }
    }

    /**
     * @param string $named
     * @return Proxy
     */
    public function proxy(string $named) : Proxy
    {
        return $this->app->get($named);
    }

    /**
     * @param string ...$classes
     */
    private function addCommand(string ...$classes) : void
    {
        foreach ($classes as $class) {
            $this->app->add(
                $this->setCommandPTS(
                    (new Proxy())->setBootstrap($this->boot)->setCommand($class),
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
}
