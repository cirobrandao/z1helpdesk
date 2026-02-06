<?php

declare(strict_types=1);

namespace App\Http;

use App\Http\Middleware\CsrfMiddleware;

final class Router
{
    private array $routes = [];

    public function get(string $path, array $handler, array $middlewares = []): void
    {
        $this->routes[] = ['GET', $path, $handler, $middlewares];
    }

    public function post(string $path, array $handler, array $middlewares = []): void
    {
        $this->routes[] = ['POST', $path, $handler, $middlewares];
    }

    public function registerRoutes(): void
    {
        $csrf = [new CsrfMiddleware()];

        $this->get('/', [\App\Http\Controllers\PublicController::class, 'home']);
        $this->get('/public/tickets/new', [\App\Http\Controllers\PublicController::class, 'createTicket']);
        $this->post('/public/tickets', [\App\Http\Controllers\PublicController::class, 'storeTicket'], $csrf);
        $this->get('/public/tickets/{token}', [\App\Http\Controllers\PublicController::class, 'showTicket']);

        $guest = [new \App\Http\Middleware\GuestMiddleware()];
        $this->get('/admin/login', [\App\Http\Controllers\AuthController::class, 'loginForm'], $guest);
        $this->post('/admin/login', [\App\Http\Controllers\AuthController::class, 'login'], array_merge($guest, $csrf));
        $this->post('/admin/logout', [\App\Http\Controllers\AuthController::class, 'logout'], $csrf);

        $auth = [new \App\Http\Middleware\AuthMiddleware()];
        $deptPerm = new \App\Http\Middleware\RbacMiddleware('departments.manage');
        $sectorPerm = new \App\Http\Middleware\RbacMiddleware('sectors.manage');
        $faqPerm = new \App\Http\Middleware\RbacMiddleware('faq.manage');
        $ticketPerm = new \App\Http\Middleware\RbacMiddleware('tickets.manage_all');

        $this->get('/admin', [\App\Http\Controllers\AdminController::class, 'dashboard'], $auth);
        $this->get('/admin/departments', [\App\Http\Controllers\DepartmentController::class, 'index'], array_merge($auth, [$deptPerm]));
        $this->get('/admin/departments/new', [\App\Http\Controllers\DepartmentController::class, 'create'], array_merge($auth, [$deptPerm]));
        $this->post('/admin/departments', [\App\Http\Controllers\DepartmentController::class, 'store'], array_merge($auth, [$deptPerm], $csrf));

        $this->get('/admin/sectors', [\App\Http\Controllers\SectorController::class, 'index'], array_merge($auth, [$sectorPerm]));
        $this->get('/admin/sectors/new', [\App\Http\Controllers\SectorController::class, 'create'], array_merge($auth, [$sectorPerm]));
        $this->post('/admin/sectors', [\App\Http\Controllers\SectorController::class, 'store'], array_merge($auth, [$sectorPerm], $csrf));

        $this->get('/admin/faqs', [\App\Http\Controllers\FaqController::class, 'index'], array_merge($auth, [$faqPerm]));
        $this->get('/admin/faqs/new', [\App\Http\Controllers\FaqController::class, 'create'], array_merge($auth, [$faqPerm]));
        $this->post('/admin/faqs', [\App\Http\Controllers\FaqController::class, 'store'], array_merge($auth, [$faqPerm], $csrf));

        $this->get('/admin/tickets', [\App\Http\Controllers\TicketController::class, 'index'], array_merge($auth, [$ticketPerm]));
        $this->get('/admin/tickets/{id}', [\App\Http\Controllers\TicketController::class, 'show'], array_merge($auth, [$ticketPerm]));
        $this->post('/admin/tickets/{id}/reply', [\App\Http\Controllers\TicketController::class, 'reply'], array_merge($auth, [$ticketPerm], $csrf));
        $this->post('/admin/tickets/{id}/close', [\App\Http\Controllers\TicketController::class, 'close'], array_merge($auth, [$ticketPerm], $csrf));

        $this->get('/client', [\App\Http\Controllers\ClientController::class, 'dashboard'], $auth);
        $this->get('/client/tickets/new', [\App\Http\Controllers\ClientController::class, 'createTicket'], $auth);
        $this->post('/client/tickets', [\App\Http\Controllers\ClientController::class, 'storeTicket'], array_merge($auth, $csrf));

        $this->get('/agent', [\App\Http\Controllers\AgentController::class, 'dashboard'], $auth);
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

        foreach ($this->routes as [$routeMethod, $routePath, $handler, $middlewares]) {
            if ($method !== $routeMethod) {
                continue;
            }

            $params = $this->match($routePath, $path);
            if ($params === null) {
                continue;
            }

            $request = new Request(
                $method,
                $path,
                $params,
                $_GET,
                $_POST,
                $_FILES,
                $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'
            );

            $pipeline = array_reverse($middlewares);
            $handlerFn = function (Request $request) use ($handler): mixed {
                [$class, $method] = $handler;
                $controller = new $class();
                return $controller->$method($request);
            };

            $next = $handlerFn;
            foreach ($pipeline as $middleware) {
                $next = fn(Request $request) => $middleware->handle($request, $next);
            }

            $response = $next($request);
            if (is_string($response)) {
                echo $response;
            }
            return;
        }

        http_response_code(404);
        echo 'Not Found.';
    }

    private function match(string $routePath, string $path): ?array
    {
        $pattern = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_-]*)\}#', '(?P<$1>[^/]+)', $routePath);
        $pattern = '#^' . $pattern . '$#';

        if (!preg_match($pattern, $path, $matches)) {
            return null;
        }

        $params = [];
        foreach ($matches as $key => $value) {
            if (!is_int($key)) {
                $params[$key] = $value;
            }
        }

        return $params;
    }
}
