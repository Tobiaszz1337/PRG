<?php

class UserController extends Controller
{
    // GET /users
    public function index(): void
    {
        $users = User::orderBy('created_at', 'DESC')->all();

        $this->view('users.index', [
            'title' => 'Uživatelé',
            'users' => $users,
        ]);
    }

    // GET /users/create
    public function create(): void
    {
        $this->view('users.create', [
            'title' => 'Nový uživatel',
        ]);
    }

    // POST /users
    public function store(): void
    {
        $data = $this->validate([
            'name'  => $this->input('name'),
            'email' => $this->input('email'),
        ]);

        if ($data === null) {
            $this->view('users.create', [
                'title' => 'Nový uživatel',
                'error' => 'Vyplňte jméno a e-mail.',
            ]);
            return;
        }

        $data['created_at'] = date('Y-m-d H:i:s');
        User::create($data);

        $this->flash('success', 'Uživatel byl vytvořen.');
        $this->redirect('/users');
    }

    // GET /users/:id
    public function show(string $id): void
    {
        $user = User::find((int) $id);

        if (!$user) {
            http_response_code(404);
            echo '<h1>Uživatel nenalezen</h1>';
            return;
        }

        $this->view('users.show', [
            'title' => $user['name'],
            'user'  => $user,
        ]);
    }

    // GET /users/:id/edit
    public function edit(string $id): void
    {
        $user = User::find((int) $id);

        if (!$user) {
            $this->redirect('/users');
        }

        $this->view('users.edit', [
            'title' => 'Upravit: ' . $user['name'],
            'user'  => $user,
        ]);
    }

    // POST /users/:id  (with _method=PUT)
    public function update(string $id): void
    {
        $data = $this->validate([
            'name'  => $this->input('name'),
            'email' => $this->input('email'),
        ]);

        $user = User::find((int) $id);

        if (!$user) {
            $this->redirect('/users');
        }

        if ($data === null) {
            $this->view('users.edit', [
                'title' => 'Upravit uživatele',
                'user'  => $user,
                'error' => 'Vyplňte jméno a e-mail.',
            ]);
            return;
        }

        User::update((int) $id, $data);

        $this->flash('success', 'Uživatel byl aktualizován.');
        $this->redirect('/users');
    }

    // DELETE /users/:id  (POST _method=DELETE)
    public function destroy(string $id): void
    {
        User::delete((int) $id);
        $this->flash('success', 'Uživatel byl smazán.');
        $this->redirect('/users');
    }

    // ── Private helpers ──────────────────────────────────────────────────

    private function validate(array $fields): ?array
    {
        foreach ($fields as $value) {
            if (empty(trim((string) $value))) {
                return null;
            }
        }
        return array_map(fn($v) => htmlspecialchars(trim((string) $v), ENT_QUOTES), $fields);
    }
}
