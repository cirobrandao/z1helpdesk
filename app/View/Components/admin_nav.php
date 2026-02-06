<nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="/admin">Z1 Helpdesk</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="/admin/departments">Departments</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/sectors">Sectors</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/faqs">FAQ</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/tickets">Tickets</a></li>
            </ul>
            <form method="post" action="/admin/logout" class="d-flex">
                <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\App\Security\Csrf::token()) ?>">
                <button class="btn btn-outline-light btn-sm" type="submit">Logout</button>
            </form>
        </div>
    </div>
</nav>
