<?php

class ContactController extends Controller
{
    public function index(): void
    {
        $this->view('contact.index', [
            'title'   => 'Kontakt',
            'heading' => 'Kontaktujte nás',
        ]);
    }
}
