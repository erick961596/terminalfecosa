<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ColaboracionMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public array   $datos,
        public ?string $adjuntoPath,
        public ?string $adjuntoNombre,
    ) {}

    public function envelope(): Envelope
    {
        $ruta = $this->datos['ruta'] ?? 'Sin especificar';
        return new Envelope(
            subject: "🚌 Nueva colaboración de horarios – {$ruta}",
            replyTo: $this->datos['nombre'] ? [] : [],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.colaboracion',
        );
    }

    public function attachments(): array
    {
        if (!$this->adjuntoPath) return [];

        return [
            Attachment::fromStorageDisk('local', $this->adjuntoPath)
                ->as($this->adjuntoNombre)
                ->withMime($this->getMime()),
        ];
    }

    private function getMime(): string
    {
        $ext = strtolower(pathinfo($this->adjuntoNombre ?? '', PATHINFO_EXTENSION));
        return match($ext) {
            'pdf'        => 'application/pdf',
            'xlsx'       => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'xls'        => 'application/vnd.ms-excel',
            'jpg','jpeg' => 'image/jpeg',
            'png'        => 'image/png',
            default      => 'application/octet-stream',
        };
    }
}
