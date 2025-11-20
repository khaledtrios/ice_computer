<?php

namespace App\Mail;

use App\Models\Boutique;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Demande;
use Barryvdh\DomPDF\Facade\Pdf;

class GenericDemandeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $demande;
    public $boutique;
    public $isClient;

    public function __construct(Demande $demande, Boutique $boutique, $isClient = true)
    {
        $this->demande = $demande;
        $this->boutique = $boutique;
        $this->isClient = $isClient;
    }

    public function build()
    {
        $pdf = Pdf::loadView('emails.demandes-pdf', [
            'demande' => $this->demande,
            'boutique' => $this->boutique
        ])
            ->setPaper('a4')
            ->setOptions([
                'defaultFont' => 'Arial',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'dpi' => 96
            ]);
        
        
        $view = ($this->isClient)?'emails.demandes_client':'emails.demandes';
        
        $type = $this->demande->type?'Devis':'Rendez-vous';
        return $this->subject($this->isClient ? "Votre {$type} - Model Itech":"Nouveau {$type} - Model Itech")
            ->view($view, [
                'demande' => $this->demande,
                'boutique' => $this->boutique,
                'isClient' => $this->isClient
            ])
            ->attachData($pdf->output(), 'devis.pdf', [
                'mime' => 'application/pdf',
            ]);
    }

}