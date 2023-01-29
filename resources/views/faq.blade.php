@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Frequenty Asked Questions (FAQ)</h1>
    

    <div class="mb-5 bg-white p-3">
        <div class="mb-3 fw-bold fs-4">
            Q: How to claim a gift?
        </div>    
        <div class="fs-3">
            A: The receiver of the gift can present the QR code to the establishment in order to claim the item. 
            Please check the "<a href="how-to-claim">how to claim</a>" page for more details.
        </div>
    </div>


    <div class="mb-5 bg-white p-3">
        <div class="mb-3 fw-bold fs-4">
            Q: What happens if I sent the gift to the wrong person?
        </div>    
        <div class="fs-3">
            A: 
        </div>
    </div>
    
    <div class="mb-5 bg-white p-3">
        <div class="mb-3 fw-bold fs-4">
            Q: What happens if the gift item I want to claim is not available or is out of stock.
        </div>    
        <div class="fs-3">
            A: All gift items can be substituted for another item with equal or lesser value upon cliaming. 
            Note that no monetary change is given for items with lesser value.
        </div>
    </div>

    
    <div class="mb-5 bg-white p-3">
        <div class="mb-3 fw-bold fs-4">
            Q: How do I refund a gift item?
        </div>    
        <div class="fs-3">
            A: Only the buyer of the gift can request a refund. 
            <br>
            In order to initiate the process, please email us using your registered email at "refund@beam.gifts".
            <br>
            Note that refunds are subject to our <a href="/tos">terms of service</a>, and due to third party payment providers we will not be able to refund
            the exact amount.
        </div>
    </div>


    <div class="mb-5 bg-white p-3">
        <div class="mb-3 fw-bold fs-4">
            Q: What happens if the brand or service is no longer available and my gift has not yet been claimed.
        </div>    
        <div class="fs-3">
            A: In the event that the brand or service has closed down or no longer exists, the buyer of the gift can request for a refund on the said item.
            Note that the gift item must not be expired in order to request a refund.
        </div>
    </div>

</div>


@endsection