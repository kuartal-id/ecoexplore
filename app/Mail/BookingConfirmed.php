<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/** Sent by BookingPayments::markPaid() once payment is verified. */
class BookingConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking)
    {
        $this->locale($booking->locale ?: config('app.locale'));
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: __('ui.mail.confirmed_subject', ['ref' => $this->booking->reference]));
    }

    public function content(): Content
    {
        return new Content(view: 'mail.booking', with: ['booking' => $this->booking, 'kind' => 'confirmed']);
    }
}
