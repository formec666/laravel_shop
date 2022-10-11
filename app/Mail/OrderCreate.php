<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Order;

class OrderCreate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $payment, $url)
    {
        $this->order = $order;
        $this->payment = $payment;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //$payment=$this->$order->payment_method;
        return $this->view('admin.mail')->with(['order'=>$this->order, 'payment'=>$this->payment, 'url'=>$this->url])->subject('Objednávka '. $this->order->id .' vytvořena');
    }
}
