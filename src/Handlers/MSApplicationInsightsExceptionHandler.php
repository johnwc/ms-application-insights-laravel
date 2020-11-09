<?php

namespace Marchie\MSApplicationInsightsLaravel\Handlers;

use Exception;
use Illuminate\Container\Container;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Marchie\MSApplicationInsightsLaravel\MSApplicationInsightsHelpers;

class MSApplicationInsightsExceptionHandler extends ExceptionHandler
{

    /**
     * @var MSApplicationInsightsHelpers
     */
    private $msApplicationInsightsHelpers;


    public function __construct(Container $app)
    {
        $this->msApplicationInsightsHelpers = app(MSApplicationInsightsHelpers::class);

        parent::__construct($app);
    }

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     *
     * @return void
     *
     * @throws Exception
     */
    public function report(\Throwable $e)
    {
        if ($this->shouldntReport($e)) {
            return;
        }

        $this->msApplicationInsightsHelpers->trackException($e);
        parent::report($e);
    }
}
