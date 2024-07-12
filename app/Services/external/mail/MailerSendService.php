<?php
namespace App\Services\external\mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\HtmlString;
use MailerSend\Helpers\Builder\Personalization;
use MailerSend\Helpers\Builder\Variable;
use Illuminate\Support\Arr;
use MailerSend\LaravelDriver\MailerSendTrait;
use Illuminate\Mail\Mailables\Content;


class MailerSendService extends Mailable
{
    use Queueable, SerializesModels, MailerSendTrait;

    public $subject;

    public function __construct(string $subject)
    {
        $this->subject = $subject;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,

        );
    }

    public function content(): Content
    {
        $to = Arr::get($this->to, '0.address');

        //Additional options for MailerSend API features
        // $this->mailersend(
        //     template_id: null,
        //     // variables: [
        //     //     new Variable($to, ['name' => 'Your Name'])
        //     // ],
        //     //tags: ['tag'],
        //     // personalization: [
        //     //     new Personalization($to, [
        //     //         'var' => 'variable',
        //     //         'number' => 123,
        //     //         'object' => [
        //     //             'key' => 'object-value'
        //     //         ],
        //     //         'objectCollection' => [
        //     //             [
        //     //                 'name' => 'John'
        //     //             ],
        //     //             [
        //     //                 'name' => 'Patrick'
        //     //             ]
        //     //         ],
        //     //     ])
        //     // ],
        //     precedenceBulkHeader: true,
        //     sendAt: new Carbon(\Date::now()),
        // );

        //$this->text('Ola seja bem vindo ao nosso sistema '. $to .'!');

        $content=  new Content(
           // text: new HtmlString('Ola seja bem vindo ao nosso sistema2 '. $to .'!')
            // view:null,
            // text: 'Ola seja bem vindo ao nosso sistema2 '. $to .'!',
          //  html: '<h1>Ola seja bem vindo ao nosso sistema '. $to .'!</h1>'
        );

        $this->text(new HtmlString('Ola seja bem vindo ao nosso sistema '. $to .'!'));

        //$content->text('Ola seja bem vindo ao nosso sistema '. $to .'!');

        return $content;



    }

    // public function sendEmail(string $to, string $subject, string $message)
    // {
    //     $envelope = new Envelope();
    //     $envelope->subject($subject);
    // }
}
