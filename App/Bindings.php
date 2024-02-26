<?php

namespace App;

use App\Http\Controllers\PostController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\RequestFlow;
use App\Http\ResponseFlow;
use App\Http\ResponseMiddleware\DefaultHeaders\DefaultHeaders;
use App\Http\ResponseMiddleware\DefaultHeaders\DefaultHeadersAbstract;
use App\Models\Posts\PostRepositoryInterface;
use App\Models\Posts\RawSqlPostRepository;
use App\Models\Users\RawSqlUserRepository;
use App\Models\Users\UserRepositoryInterface;
use App\Services\FraudDetection\FraudDetectionInterface;
use App\Services\FraudDetection\MaxMind;
use App\Services\UserNotification\UserNotification;
use App\Services\UserNotification\UserNotificationInterface;
use Config\DefaultHeaders as ConfigDefaultHeaders;
use Config\MySqlConfig;
use Config\RequestValidation;
use Config\UserNotifyConfig;
use Engine\Application\ApplicationAbstract;
use Engine\Application\BindingsInterface;
use Engine\Application\EventHandlerInterface;
use Engine\DB\DBConnectionInterface;
use Engine\DB\MysqlConnection;
use Engine\DB\MysqlGateway;
use Engine\DB\MysqlGatewayInterface;
use Engine\Http\ControllerInvoker\AbstractInvoker;
use Engine\Http\ControllerInvoker\Invoker;
use Engine\Http\Kernel\HttpKernel;
use Engine\Http\Kernel\HttpKernelAbstract;
use Engine\Http\ResponseKernel\HttpResponseKernel;
use Engine\Http\ResponseKernel\HttpResponseKernelAbstract;
use Engine\Http\PathResolver\AbstractPathResolver;
use Engine\Http\PathResolver\AttributePathResolver;
use Engine\Http\RequestFlowInterface;
use Engine\Http\RequestValidation\ValidationRulesFactory;
use Engine\Http\RequestValidation\ValidationRulesFactoryAbstract;
use Engine\Http\RequestValidation\Validator;
use Engine\Http\RequestValidation\ValidatorAbstract;
use Engine\Http\ResponseFlowInterface;

class Bindings implements BindingsInterface
{

    public function getBindings(): array
    {
        return [
            ValidationRulesFactoryAbstract::class => function (ApplicationAbstract $app) {
                return new ValidationRulesFactory(
                    RequestValidation::load(),
                    $app
                );
            },
            ValidatorAbstract::class => function (ApplicationAbstract $app) {
                return new Validator(
                    $app->make(ValidationRulesFactoryAbstract::class)
                );
            },
            UserRepositoryInterface::class => function (ApplicationAbstract $app) {
                return new RawSqlUserRepository(
                    $app->make(MysqlGatewayInterface::class)
                );
            },
            PostRepositoryInterface::class => function (ApplicationAbstract $app) {
                return new RawSqlPostRepository(
                    $app->make(MysqlGatewayInterface::class)
                );
            },
            
        ];
    }
    public function getSingletons(): array
    {
        return [
            EventHandlerInterface::class => function(ApplicationAbstract $app){
                return new EventHandler($app);
            },
            RequestFlowInterface::class => RequestFlow::class,
            ResponseFlowInterface::class => ResponseFlow::class,
            HttpKernelAbstract::class => function (ApplicationAbstract $app) {
                return new HttpKernel($app);
            },
            HttpResponseKernelAbstract::class => function (ApplicationAbstract $app) {
                return new HttpResponseKernel($app);
            },
            AbstractInvoker::class => function (ApplicationAbstract $app) {
                return new Invoker($app);
            },
            AbstractPathResolver::class => function (ApplicationAbstract $app) {
                return new AttributePathResolver([
                    TestController::class,
                    UserController::class,
                    PostController::class
                ], $app);
            },
            DefaultHeadersAbstract::class => function (ApplicationAbstract $app) {
                return new DefaultHeaders(ConfigDefaultHeaders::load());
            },
            DBConnectionInterface::class => function (ApplicationAbstract $app) {
                return new MysqlConnection(MySqlConfig::load());
            },
            MysqlGatewayInterface::class => function (ApplicationAbstract $app) {
                return new MysqlGateway($app->make(DBConnectionInterface::class));
            },
            UserNotificationInterface::class => function (ApplicationAbstract $app) {
                return new UserNotification(UserNotifyConfig::load());
            },
            FraudDetectionInterface::class => function (ApplicationAbstract $app) {
                return new MaxMind();
            },

        ];
    }
}
