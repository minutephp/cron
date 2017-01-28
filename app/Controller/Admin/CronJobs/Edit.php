<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Admin\CronJobs {

    use Minute\Resolver\Resolver;
    use Minute\Routing\RouteEx;
    use Minute\Utils\PathUtils;
    use Minute\View\Helper;
    use Minute\View\View;
    use ReflectionClass;
    use ReflectionMethod;

    class Edit {
        /**
         * @var Resolver
         */
        private $resolver;
        /**
         * @var PathUtils
         */
        private $utils;

        /**
         * Edit constructor.
         *
         * @param Resolver $resolver
         * @param PathUtils $utils
         */
        public function __construct(Resolver $resolver, PathUtils $utils) {
            $this->resolver = $resolver;
            $this->utils    = $utils;
        }

        public function index(RouteEx $_route) {
            $folders     = $this->resolver->find('App\Controller\Cron');
            $controllers = [];
            foreach ($folders as $folder) {
                $classes = glob("$folder/*.php");
                foreach ($classes as $classPath) {
                    $class = sprintf('\App\Controller\Cron\%s', $this->utils->filename($classPath));
                    if (class_exists($class)) {
                        if ($reflector = new ReflectionClass($class)) {
                            foreach ($reflector->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                                if (!preg_match('/^\_/', $method->name)) {
                                    $controller = ['type' => ucwords(basename(dirname($classPath, 4))), 'value' => sprintf("%s@%s", $method->class, $method->name),
                                                   'name' => sprintf("%s@%s", $this->utils->filename($method->class), $method->name)];
                                    array_push($controllers, $controller);
                                }
                            }
                        }
                    }
                }
            }

            return (new View())->with(new Helper('NyaSelect'))->set('controllers', $controllers);
        }
    }
}